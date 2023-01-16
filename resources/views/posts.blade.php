@extends('layouts.app')
@section('content')
<body>
    <div id="login" class="container">
        <div class="row-fluid">
            <div class="span12">
                <div class="login well well-small">
                    <div class="center">
                        <form class="row g-3 needs-validation" novalidate>
                            <div class="alert alert-danger print-error-msg" style="display:none">
                                <ul></ul>
                            </div>
                            <div class="col-md-12">
                                <label for="exampleFormControlInput1" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="emailID" placeholder="name@example.com">
                            </div>
                            <div class="col-md-12">
                                <label for="validationCustom01" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phoneID" value="+7" required>
                            <div class="col-md-12">
                                <label for="validationCustomUsername" class="form-label">Username</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                                    <input type="text" class="form-control" id="loginID" aria-describedby="inputGroupPrepend" required>
                                </div>
                            </div>
                            <br>
                            <div class="mb-12 text-center">
                                <button class="btn btn-success btn-submit">Сохранить и отправить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
  
<script type="text/javascript">
      
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    $(".btn-submit").click(function(e){
    
        e.preventDefault();
        var email = $("#emailID").val();
        var phone = $("#phoneID").val();
        var login = $("#loginID").val();
     
        $.ajax({
           type:'POST',
           url:"{{ route('posts.store') }}",
           data:{email:email, phone:phone, login:login},
           success:function(data){
                if($.isEmptyObject(data.error)){
                    alert(data.success);
                    location.reload();
                }else{
                    printErrorMsg(data.error);
                }
           }
        });
    
    });
  
    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }
  
</script>
@endsection