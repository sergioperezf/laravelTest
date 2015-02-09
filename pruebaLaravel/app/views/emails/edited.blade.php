<h2>Hello, {{$user->username}}!</h2>
<br/>
You have edited your profile on http://laravel.seperez.com. To login, go to http://laravel.seperez.com.
<br/>
<br/>
This is your new profile:
<br/>

Name: {{$user->name}}<br/>
Lastname: {{$user->lastname}}<br/>
Phone: {{$user->phone}}<br/>
Birthday: {{$user->birthday}}<br/>
Picture: @if(Picture::find($user->picture_id))
<br/> 
<img style="width: 200px" src="<?php echo $message->embed(public_path(Picture::find($user->picture_id)->path)); ?>">
@else
Not set
@endif
<br/>
<br/>
Best regards,
<br/>
<br/>
Sergio