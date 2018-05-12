Hello {{$user->name}},
<br>
Click here to reset your password: {{ url('password/reset/'.$token) }}
