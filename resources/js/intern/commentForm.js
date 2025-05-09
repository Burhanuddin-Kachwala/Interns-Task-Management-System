import axios from 'axios';
import $ from 'jquery';

$(document).ready(function () {
    //scrolling towards last
    const commentList = $('#commentList');
    commentList.scrollTop(commentList[0].scrollHeight);

    console.log('Comment form script loaded');
    $('#intern_comment_form').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const comment = form.find('textarea[name="comment"]').val();

        axios.post(form.attr('action'), {
            comment: comment,
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        })
        .then(function(response) {
            console.log('Comment posted successfully:', response.data);
            const newComment = response.data;
            const commentHtml = `
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <p class="text-gray-700">${newComment.comment.comment}</p>
                    <div class="flex items-center mt-3">
                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                            <span class="text-indigo-600 font-semibold">${newComment.intern_name.charAt(0)}</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">${newComment.intern_name}</p>
                            <p class="text-xs text-gray-500">Just now</p>
                        </div>
                    </div>
                </div>
            `;
            $('.space-y-4').append(commentHtml);
            form.find('textarea').val('');
        })
        .catch(function(error) {
            console.error('Error:', error);
            alert('Failed to post comment. Please try again.');
        });
    });
});
