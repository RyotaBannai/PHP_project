<form action="{{ route('comment.show', ['user' => 1]) }}">
    @method('post')
{{ Form::select('animal', array(
    'Cats' => array('leopard' => 'Leopard'),
    'Dogs' => array('spaniel' => 'Spaniel'),
))}}
    <a href = {{ $tmpUrl }}>this is real link.</a>
<button class="btn" type="submit">Submit</button>
</form>

