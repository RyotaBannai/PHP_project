<div class="message">
    <div class="alert alert-error">
        @isset($error)
            You got this error message:
            {{ $error }}
        @endisset
    </div>
    <div class="success">
        @isset($success)
            {{ $success }}
        @endisset
    </div>
</div>
<script>
</script>

