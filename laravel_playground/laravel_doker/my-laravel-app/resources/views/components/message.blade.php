<div class="message">
    <div class="alert alert-error">
        @isset($error)
            You got this error message:
            {{ $error }}
        @endisset
    </div>
    <div class="default">
        @isset($success)
            {{ $success }}
        @endisset
    </div>
</div>
<script>

    /*
    css variable control
    let root = document.documentElement;
    root.addEventListener("mousemove", e => {
        root.style.setProperty('--mouse-x', e.clientX + "px");
        root.style.setProperty('--mouse-y', e.clientY + "px");
    });
    */

</script>

