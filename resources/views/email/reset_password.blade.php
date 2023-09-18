<h1>Reset Password</h1>

<p>You are receiving this email because we received a password reset request for your account.</p>
<a href="{{url('reset-password', [$token])}}?user={{$email}}" style="border: 0;padding: 10px 16px;background-color: #2a2a2a;color: #fff;font-size: 16px;border-radius: 5px;text-decoration: none;" >Reset Password</a>
<p>This password reset link will expire in 60 minutes.
<br/>
If you did not request a password reset, no further action is required.</p>
<hr/>
<p><small>
If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: {{url('reset-password', [$token])}}?user={{$email}}
</small></p>