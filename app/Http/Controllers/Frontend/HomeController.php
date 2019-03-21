<?php

namespace App\Http\Controllers\Frontend;

use App\Http\View\Composers\SeriesComposer;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Page;
use App\Models\Post;
use App\Models\Series;
use App\Models\Tag;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use PhpParser\Node\Stmt\Case_;
use App\Models\Quiz;
use App\Models\QuizQuestion;

class HomeController extends Controller
{
    public function index()
    {
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $data['posts'] = Cache::rememberForever('posts' . $currentPage, function () {
            return Post::with('category')->orderBy('id', 'desc')->paginate(8);
        });
        Cache::forever('postTotalPage', $data['posts']->lastPage());

        $data['categoriesTopPage'] = Category::select("slug", "name", "featuredImage")->where([
            "status"      => 1,
            "homepageTop" => 1
        ])->get();

        $data['postsTopPage'] = Post::select("slug", "title", "featuredImage")->where([
            "status"      => 1,
            "homepageTop" => 1,

        ])->get();

        $data['seriesTopPage'] = Series::select("slug", "name", "featuredImage")->where([
            "status"      => 1,
            "homepageTop" => 1
        ])->get();

        return view('frontend.home', $data);
    }

    public function showpost($slug, $commentid = 0)
    {
        $data = [];
        try {
            $data['post'] = Post::with('category')->where("slug", $slug)->first();
            if ($commentid != 0) {
                if (Auth::check()) {
                    $comment = Comment::find($commentid);
                    $comment->visited = 1;
                    $comment->save();
                }
            }
            $data['quizzes'] = Quiz::where('post_id', $data['post']->id)->get();
            $data['releteadposts'] = Post::with('category')->where('categoryId', $data['post']->categoryId)->limit(3)->inRandomOrder()->get();

            return view('frontend.showpost', $data);
        } catch (\Exception $exception) {
            return redirect()->route('frontend.error');
        }
    }

    public function showquiz($quizslug)
    {
        try {
            $quiz = $data['quiz'] = Quiz::with('posts')->where('slug', $quizslug)->first();
            $questions =  $data['questions'] = QuizQuestion::with('answers')->where('quiz_id', $quiz->id)->get();
            if (count($questions) > 0) {
                return view('frontend.showquiz', $data);
            } else {
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            return redirect()->route('frontend.error');
        }
    }

    public function showcategory($slug)
    {
        $data = [];
        try {
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

            $data['category'] = Category::where([
                'slug'   => $slug,
                'status' => 1
            ])->first();


            $data['posts'] = Cache::rememberForever($data['category']->id . 'categoryPost' . $currentPage, function () use ($data) {
                return Post::where([
                    'categoryId' => $data['category']->id,
                    'status'     => 1
                ])->paginate(10);
            });

            Cache::forever($data['category']->id . 'categoryTotalPostPage', $data['posts']->lastPage());

            return view('frontend.showcategory', $data);
        } catch (\Exception $exception) {
            return redirect()->route('frontend.error');
        }
    }

    public function showpage($slug)
    {
        $data = [];

        try {
            $data['page'] = Page::where([
                'slug'   => $slug,
                'status' => 1
            ])->first();

            return view('frontend.showpage', $data);
        } catch (\Exception $exception) {
            return redirect()->route('frontend.error');
        }
    }

    public function showtag($tag)
    {
        try {
            $data[] = "";
            $tag = $data['tag'] = Tag::with('posts')->where('name', $tag)->first();
            $data['posts'] = Tag::find($tag->id)->posts()->paginate(10);

            return view('frontend.showtag', $data);
        } catch (\Exception $exception) {
            return redirect()->route('frontend.error');
        }
    }

    public function contact()
    { }

    public function generatepdf($type, $slug)
    {
        $data = [];
        try {
            if ($type == "post") {
                $data['post'] = Post::where('slug', $slug)->first();
            }

            $mpdf = new Mpdf();

            $html = view('frontend.pdf.post', $data)->render();
            $mpdf->setFooter('{PAGENO}');
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } catch (\Exception $exception) {
            return redirect()->route('frontend.error');
        }
    }

    public function showseries($sslug, $catsulg = "", $pslug = "")
    {
        $data = [];
        $data['tmparray'] = [];
        $data['cattmparray'] = [];
        try {
            $cachedata = Cache::rememberForever('series' . $sslug, function () use ($sslug) {
                $ca = [];
                $series = $ca['series'] = Series::with('categories')->where('slug', $sslug)->first();
                foreach ($series->categories as $key => $category) {
                    $categories[$key]['catid'] = $category->id;
                    $categories[$key]['name'] = $category->name;
                    $categories[$key]['slug'] = $category->name;
                    $categories[$key]['sort_order'] = $category->pivot->sort_order;
                    $categories[$key]['series_id'] = $series->id;
                    $categories[$key]['posts'] = Post::where('categoryId', $category->id)->orderBy('sort_order', 'asc')->get();
                }
                $ca['results'] = array_values(Arr::sort($categories, function ($value) {
                    return $value['sort_order'];
                }));

                return $ca;
            });
            $data['series'] = $cachedata['series'];
            $results = $data['results'] = $cachedata['results'];

            if ($catsulg == "") {
                $data['post'] = $results[0]['posts'][0];
                $data['catid'] = $results[0]['catid'];
            } else {
                foreach ($results as $catkey => $result) {
                    if ($result['slug'] == $catsulg) {
                        if ($pslug != "") {
                            $check = 0;
                            foreach ($result['posts'] as $pkey => $post) {
                                if ($post->slug == $pslug) {
                                    $data['post'] = $post;
                                    $data['catid'] = $result['catid'];
                                    $check = 1;
                                    break;
                                }
                            }
                            if ($check == 0) {
                                $data['post'] = $result['posts'][0];
                                $data['catid'] = $result['catid'];
                                break;
                            }
                        } else {
                            $data['post'] = $result['posts'][0];
                            $data['catid'] = $result['catid'];
                            break;
                        }
                    }
                }
            }

            return view('frontend.showseries', $data);
        } catch (\Exception $exception) {
            return redirect()->route('frontend.error');
        }
    }

    public function getCommentsform($postSlug)
    {
        $data['post'] = Post::with('category')->where("slug", $postSlug)->first();

        return view('frontend.postcomments', $data);
    }

    public function getComments($postid)
    {
        $data['comments'] = Comment::with('visitors')->where(['post_id' => $postid])->orderBy('id', 'desc')->get();

        return view('frontend.commentsection', $data);
    }

    public function saveComments(Request $request, $postid)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["Fill form correctly"]);
        }
        try {
            $visitorid = Auth::guard('visitor')->check() == false ? null : true;
            $comment = new Comment();
            $comment->comment = $request->comment;
            $comment->post_id = $postid;
            $comment->visitor_id = $visitorid != null ? Auth::guard('visitor')->id() : null;
            if ($visitorid == null) {
                $comment->visited = 1;
            }
            $comment->save();

            return response()->json(["DONE"]);
        } catch (\Exception $exception) {
            return response()->json([$exception->getMessage()]);
        }
    }

    public function updateComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["ERROR"]);
        }
        try {
            $comment = Comment::find($request->commentid);
            $comment->comment = $request->comment;
            $comment->save();

            return response()->json([$comment->comment]);
        } catch (\Exception $exception) {
            return response()->json(["ERROR"]);
        }
    }

    public function deleteComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'commentid' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(["ERROR"]);
        }
        try {
            Comment::destroy($request->commentid);

            return response()->json(["DONE"]);
        } catch (\Exception $exception) {
            return response()->json(["ERROR"]);
        }
    }

    public function searchpost(Request $request)
    {
        try {
            if (strlen($request->searchword) <= 0) {
                return redirect()->back();
            }
            $data['searchkeyword'] = $request->searchword;
            $data['posts'] = DB::table('posts')->whereRaw(" MATCH(title,content) AGAINST('$request->searchword')")->paginate(15);
            $data['posts']->withPath('searchpost/' . $request->searchword);

            return view('frontend.searchpost', $data);
        } catch (\Exception $exception) {
            return redirect()->route('frontend.error');
        }
    }

    public function paginatesearchpost($keyword)
    {

        try {
            $data['searchkeyword'] = $keyword;
            $data['posts'] = DB::table('posts')->whereRaw(" MATCH(title,content) AGAINST('$keyword')")->paginate(15);
            $data['posts']->withPath($keyword);

            return view('frontend.searchpost', $data);
        } catch (\Exception $exception) {
            return redirect()->route('frontend.error');
        }
    }
}
