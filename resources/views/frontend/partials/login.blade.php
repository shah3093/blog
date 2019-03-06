<!-- Modal -->
<div id="loginModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Login</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="logingfrmid" action="{{route('visitors.loginajax')}}" method="post">

                    <div id="errordiv" style="color: red;">

                    </div>
                    <div class="form-group">
                        <label for="email">Email address:</label>
                        <input name="email" type="email" required class="form-control required" id="email">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input name="password" type="password" required class="form-control" id="pwd">
                    </div>
                    <a href="{{route('visitors.registrationform')}}">Sign up form</a>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                <button type="button" data-url="{{route('visitors.loginajax')}}" class="btn btn-primary" id="submitdata">
                    Submit
                </button>
            </div>
        </div>

    </div>
</div>


