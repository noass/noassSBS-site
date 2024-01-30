$('.like').on('click', function(event){
    event.preventDefault();
    var isLike = true;
    var postId = event.target.parentNode.parentNode.dataset['postId'];
    console.log(isLike);
    $.ajax({
        method: 'POST',
        url: urlLike,
        data: {isLike: isLike, postId: postId, _token: token}
    });
});

$('.dislike').on('click', function(event){
    event.preventDefault();
    var isLike = false;
    var postId = event.target.parentNode.parentNode.dataset['postId'];
    console.log(isLike);
    $.ajax({
        method: 'POST',
        url: urlDislike,
        data: {isLike: isLike, postId: postId, _token: token}
    });
});