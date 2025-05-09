<x-layout>
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Task Details Section -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $task->title }}</h1>
            <div class="prose max-w-none text-gray-700 mb-4">{!! $task->description!!}</div>
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Deadline: {{ $task->deadline }}
            </div>
        </div>

        <!-- Comments Section -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Comments</h2>

            <!-- Comments List -->
            <div class="space-y-4 mb-6">
                <div id="commentList" class="h-64 overflow-y-auto">
                    @foreach ($comments->reverse() as $comment)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 mb-4">
                            <p class="text-gray-700">{{ $comment->comment }}</p>
                            <div class="flex items-center mt-3">
                                <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <span class="text-indigo-600 font-semibold">{{ substr($comment->intern->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $comment->intern->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Comment Form -->
            <form id="intern_comment_form" action="{{ route('intern.tasks.comment', $task) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <textarea 
                        name="comment" 
                        rows="3" 
                        required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none"
                        placeholder="Add your comment..."></textarea>
                </div>
                <button 
                    type="submit" 
                    class="w-full sm:w-auto px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Post Comment
                </button>
            </form>
        </div>
    </div>
   
    {{-- <script>
            
            $('#intern_comment_form').on('submit', function(e) {
                console.log('Form submitted');
                e.preventDefault();
                
                const form = $(this);
                const comment = form.find('textarea[name="comment"]').val();
                
                axios.post(form.attr('action'), {
                    comment: comment,
                    _token: '{{ csrf_token() }}'
                })
                .then(function(response) {
                    const newComment = response.data;
                    const commentHtml = `
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-gray-700">${newComment.comment}</p>
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
                    $('.space-y-4').prepend(commentHtml);
                    form.find('textarea').val('');
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    alert('Failed to post comment. Please try again.');
                });
            });
       
    </script> --}}

</x-layout>
