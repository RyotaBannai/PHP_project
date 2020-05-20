<h1>User Profile</h1>
<div style="display:flex; flex-direction: column; width: 60%;">
    <div style="display:flex;">
        <p style="flex:1">id</p>
        <p style="flex:2">name</p>
        <p style="flex:5">email</p>
        <p style="flex:1">is active</p>
    </div>

    <div style="display:flex; ">
        <p style="flex:1">{{ $user->id }}</p>
        <p style="flex:2">{{ $user->name }}</p>
        <p style="flex:5">{{ $user->email }}</p>
        @if($user->active === 1)
            <p style="flex:1; color:#42b983;">Active</p>
        @else
            <p style="flex:1; color:#7e7e7e;">Inactive</p>
        @endif
    </div>
</div>
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        line-height: 1.4;
    }
    h1{
        background: #333;
        color: #777;
        padding: 30px;
        width: 60%;
    }
    p {
        margin: 5px 0px;
    }
</style>
