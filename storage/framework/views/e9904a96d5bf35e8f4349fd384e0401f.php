<div>
    <h2 class="h4 text-center">Random Quizzes</h2>
    <div id="quiz-container" class="d-flex flex-column align-items-center">
        <?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="quiz-item mb-4" id="quiz-<?php echo e($index); ?>" style="display: none;">
                <img src="<?php echo e(Storage::url($quiz->image_url)); ?>" class="img-fluid mb-2" alt="Quiz Image" style="max-width: 300px;">
                <audio id="audio-<?php echo e($index); ?>" controls class="mb-2">
                    <source src="<?php echo e(Storage::url($quiz->audio)); ?>" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
                <div class="choices">
                    <label class="choice">
                        <input type="checkbox" data-choice="1"> Choice 1
                    </label>
                    <label class="choice">
                        <input type="checkbox" data-choice="2"> Choice 2
                    </label>
                    <label class="choice">
                        <input type="checkbox" data-choice="3"> Choice 3
                    </label>
                    <label class="choice">
                        <input type="checkbox" data-choice="4"> Choice 4
                    </label>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div id="timer" class="text-center mt-3">30 seconds remaining</div>
</div>

<style>
    .quiz-item {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        background-color: #f9f9f9;
    }
    .choices {
        margin-top: 10px;
    }
    .choice {
        display: block;
        margin: 5px 0;
        font-size: 16px;
    }
    .choice input {
        margin-right: 8px;
    }
</style>

<script>
    let currentQuizIndex = 0;
    const quizzes = <?php echo json_encode($quizzes, 15, 512) ?>;
    const timerElement = document.getElementById('timer');
    let timer;

    function startTimer() {
        let timeLeft = 5;
        timerElement.innerText = timeLeft + ' seconds remaining';
        timer = setInterval(() => {
            timeLeft--;
            timerElement.innerText = timeLeft + ' seconds remaining';
            if (timeLeft <= 0) {
                clearInterval(timer);
                goToNextQuiz();
            }
        }, 1000);
    }

    function goToNextQuiz() {
        if (currentQuizIndex < quizzes.length - 1) {
            document.getElementById('quiz-' + currentQuizIndex).style.display = 'none';
            currentQuizIndex++;
            document.getElementById('quiz-' + currentQuizIndex).style.display = 'block';
            const audio = document.getElementById('audio-' + currentQuizIndex);
            audio.play();
            startTimer();
        } else {
            // Handle end of quiz logic here
            alert('Quiz completed!');
        }
    }

    document.querySelectorAll('audio').forEach((audio, index) => {
        audio.addEventListener('ended', () => {
            startTimer();
        });
    });

    document.querySelectorAll('.choice input').forEach(input => {
        input.addEventListener('change', (event) => {
            const choice = event.target.getAttribute('data-choice');
            // Handle choice selection logic here
            console.log('User selected choice:', choice);
        });
    });

    // Start with the first quiz visible
    document.getElementById('quiz-0').style.display = 'block';
    const firstAudio = document.getElementById('audio-0');
    firstAudio.play();
</script> <?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/livewire/random-quizzes.blade.php ENDPATH**/ ?>