@extends("layout")
@section("content")

<div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
    <div class="panel panel-info" >
        <div class="panel-heading">
            <div class="panel-title">Log In</div>
            <div style="float:right; font-size: 80%; position: relative; top:-10px"></div>
        </div>    
        <div style="padding-top:30px" class="panel-body" >
            {{ Form::open() }}
            <div style="margin-bottom: 25px" class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                {{ Form::text("username", null, array('class'=>'form-control', 'placeholder'=>'Email')) }}
            </div>
            <div style="margin-bottom: 25px" class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                {{ Form::password("password", array('class'=>'form-control', 'placeholder' => 'Password')) }}
            </div>
            <div style="margin-top:10px" class="form-group">
                <div class="col-sm-12 controls">
                    {{ Form::submit("Login", array('class' => 'btn btn-success')) }}
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12 control">
                    <hr/>
                    <div style=" padding-top:15px; font-size:85%" >
                        Don't have an account! 
                        <a href="#" onClick="$('#loginbox').hide();
                                $('#signupbox').show()">
                            Register Here
                        </a>
                    </div>
                </div>
            </div>    
            {{ Form::close() }}

        </div>                     
    </div>  
</div>
<div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">Register</div>
            <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide();
                    $('#loginbox').show()">Log In</a></div>
        </div>  
        <div class="panel-body" >
            {{ Form::open(array('action' => 'UserController@register', 'class' => 'form-horizontal', 'role' => 'form')) }}
            <div class="form-group">
                <div class="col-md-12">
                    {{ Form::text("username", null, array('class'=>'form-control', 'placeholder'=>'Username')) }}
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    {{ Form::text("email", null, array('class'=>'form-control', 'placeholder'=>'Email')) }}
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    {{ Form::password("password", array('class'=>'form-control', 'placeholder'=>'Password')) }}
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    {{ Form::password("password_repeat", array('class'=>'form-control', 'placeholder'=>'Repeat password')) }}
                </div>
            </div>
            <div class="form-group">
                <!-- Button -->                                        
                <div class="col-md-offset-3 col-md-9">
                    <input type="submit" id="btn-signup" class="btn btn-info" value="Register"/>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div> 
@stop