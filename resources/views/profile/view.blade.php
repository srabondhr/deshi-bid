<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile View</title>
</head>
<body>
    <h1>Profile</h1>
    <p>Name: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    <a href="{{ route('profile.edit') }}">Edit Profile</a>
</body>
</html>
