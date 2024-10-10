const idolImage = document.getElementById('idolImage');
const optionsContainer = document.getElementById('optionsContainer');
const nextBtn = document.getElementById('nextBtn');

const questions = [
    { id: 1, name: "Winter", image: "https://www.allkpop.com/upload/2024/10/content/061118/1728227880-gzntv9gbuaafbgw.jpg", options: ["Winter", "Karina", "Giselle", "Garam"], correct: "Winter" },
    { id: 2, name: "Jung-kook", image: "https://s2-quem.glbimg.com/BmiEjgYldbMUIT_AI74F68YTl3c=/0x0:1400x1016/888x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_b0f0e84207c948ab8b8777be5a6a4395/internal_photos/bs/2023/q/1/YtkV0JRUu0E5poKN7c6w/jungkook.jpg", options: ["Jimin", "Taeyon", "Jung-kook", "Hongjoong"], correct: "Jung-kook" },
    { id: 3, name: "Lisa", image: "https://www.rollingstone.com/wp-content/uploads/2024/06/blackpink-lisa-new-single.jpg?w=1581&h=1054&crop=1", options: ["Rora", "Lisa", "Jisoo", "Yren"], correct: "Lisa" },
    { id: 4, name: "Chaewon", image: "https://static.wikia.nocookie.net/love-talk/images/3/37/Le-sserafim-kim-chae-won-source-music-girl-group-2022.jpg/revision/latest/scale-to-width-down/2000?cb=20230307142319", options: ["Yuna", "Chaeryoung", "Rose", "Chaewon"], correct: "Chaewon" },
    { id: 5, name: "San", image: "https://hitmagazine.com.br/wp-content/uploads/2024/07/site-capa-tamanho-certo-19-1.png", options: ["Wooyoung", "Ten", "San", "Seongwha"], correct: "San" },
    { id: 6, name: "Felix", image: "https://cinevibes.com.br/wp-content/uploads/2024/08/2154347937.webp", options: ["Han", "Felix", "Bangchan", "I.N"], correct: "Felix" },

];

let currentQuestionIndex = 0;

function loadQuestion() {
    const currentQuestion = questions[currentQuestionIndex];
    idolImage.src = currentQuestion.image;
    optionsContainer.innerHTML = '';

    currentQuestion.options.forEach(option => {
        const button = document.createElement('button');
        button.textContent = option;
        button.classList.add('option');
        button.addEventListener('click', () => checkAnswer(option, currentQuestion.correct));
        optionsContainer.appendChild(button);
    });

    nextBtn.classList.add('hidden'); // Esconde o botão "Próximo"
}

function checkAnswer(selected, correct) {
    const buttons = document.querySelectorAll('.option');
    
    buttons.forEach(button => {
        if (button.textContent === correct) {
            button.classList.add('correct');
        } else {
            button.classList.add('wrong');
        }
        button.disabled = true; // Desabilita todos os botões após uma escolha
    });

    nextBtn.classList.remove('hidden'); // Mostra o botão "Próximo"
}

nextBtn.addEventListener('click', () => {
    currentQuestionIndex++;
    if (currentQuestionIndex < questions.length) {
        loadQuestion();
    } else {
        alert("Fim do jogo!");
        // Você pode adicionar lógica para reiniciar o jogo aqui.
    }
});

loadQuestion(); // Carrega a primeira pergunta
