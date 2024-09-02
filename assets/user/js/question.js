var countQues = 0;
// var lang;
// var score = 0;
       
window.addEventListener('DOMContentLoaded', (event) => {
    // Example: Log each description and its corresponding question details
    displayQuestions();
})

const totalScore = calculateTotalScore();
// const answerNo = generateAnswerNo();
const now = new Date();
const answerDate = now.getFullYear() + '-' +
                    String(now.getMonth() + 1).padStart(2, '0') + '-' +
                    String(now.getDate()).padStart(2, '0') + ' ' +
                    String(now.getHours()).padStart(2, '0') + ':' +
                    String(now.getMinutes()).padStart(2, '0') + ':' +
                    String(now.getSeconds()).padStart(2, '0');


function calculateTotalScore() {
    let total = 0
    questions.forEach(question => {
        total += parseInt(question.score);
    });
    return total;
}

// function generateAnswerNo() {
//     const baseString = "JLPT";

//     // Optionally, add additional logic to generate a unique or specific answer number
//     // For example, adding a random number or timestamp to the base string
//     const uniqueSuffix = Math.floor(Math.random() * 1000000); // Random number between 0 and 999

//     // Combine the base string with the unique suffix
//     return `${baseString}-${uniqueSuffix}`
// }

function getCurrentDateTime() {
    const now = new Date();

    // Get the current hours, minutes, and seconds
    let hours = now.getHours();
    let minutes = now.getMinutes();
    let seconds = now.getSeconds();

    // Determine AM or PM
    // const ampm = hours >= 12 ? 'PM' : 'AM';

    // Convert hours from 24-hour to 12-hour format
    hours = hours % 12;
    hours = hours || 12; // the hour '0' should be '12'

    // Add leading zero to minutes and seconds if needed
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;

    // Format the time string
    const timeString = `${hours}:${minutes}:${seconds}`;
    return timeString;
}

function displayQuestions() {
    localStorage.removeItem('permit');
    if (questions.length == countQues) {
        addFinalResult(countQues);
        document.querySelector("#continue").style.display="none";
        document.querySelector("#backBtn").style.display="block";
    }

    document.getElementById("ques-left").textContent="Question : "+(countQues+1)+"/"+questions.length;
    document.getElementById("question_id").value = questions[countQues].question_id;
    document.getElementById("start_time").innerHTML = getCurrentDateTime();
    document.querySelector(".question").innerHTML="<h1>"+questions[countQues].question+"</h1>";
    displayChoices(countQues);
    console.log(questions[countQues]);
    if (questions[countQues].permission == false && countQues == 0) {
        localStorage.setItem('permit', 'false');
    } else if (questions[countQues].permission == false && countQues != 0) {
        Swal.fire({
            title: "Alert",
            text: "You've made two mistakes in answering this question. Therefore, you can't provide a correct answer. Please skip it!",
            icon: "warning",
            showCancelButton: false,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Skip"
          }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("ques-view").innerHTML+="<div class='ques-circle incorrect'>"+(countQues)+"</div>";
                displayQuestions();
            }
          });
    }
    countQues++;
}

function displayChoices(index) {
    const container = document.getElementById('choiceContainer');

    // Ensure the index is within bounds
    if (index >= 0 && index < questions.length) {
        const q = questions[index];
        
        let buttonsHtml = q.choices.map((choice, choiceIndex) => `
                    <div class="col-6 mb-2">
                        <input type="radio" value="${choiceIndex}" class="btn-check" style="width: 100%;" name="options-outlined" id="success-outlined_${choiceIndex}" autocomplete="off" checked>
                        <label class="btn btn-outline-success" for="success-outlined_${choiceIndex}" style="width: 100%; margin: 0;">
                            ${choice}
                        </label>
                    </div>
                `).join('');

        container.innerHTML = `
           <div class="row">
                ${buttonsHtml}
            </div>
        `;
    } else {
        container.innerHTML = '<p>Question not found.</p>';
    }
}


document.querySelector(".submit-answer").addEventListener("click",function(){
    let question_id = document.getElementById("question_id").value;
    let start_time  = document.getElementById("start_time").textContent;
    let end_time    = getCurrentDateTime();
    let is_correct  = false;
    let scoreResult       = 0;
    const selectedChoice = document.querySelector('input[name="options-outlined"]:checked');
    
    if (selectedChoice) {
        if (selectedChoice.value == questions[countQues-1].answer) {
            is_correct = true;
            let score  = document.getElementById("score").textContent;
            let remainScore = score.split("Score : ")[1];
            let finalScore  = parseInt(remainScore) + parseInt(questions[countQues-1].score);
            scoreResult = parseInt(questions[countQues-1].score);
            document.getElementById("score").textContent = "Score : " + finalScore;
            Swal.fire({
                icon: "success",
                title: "Your Answer is Correct!!",
                text:  "Try another question!",
                footer: 'JLPT Questions TEST'
              });
              document.getElementById("ques-view").innerHTML+="<div class='ques-circle correct'>"+(countQues)+"</div>"; 
        }
        else {
            document.getElementById("ques-view").innerHTML+="<div class='ques-circle incorrect'>"+(countQues)+"</div>";
            Swal.fire({
                icon: "error",
                title: "Your Answer is Wrong!!",
                text: "Please try another question!!",
                footer: 'JLPT Questions TEST'
              });
        }
    } 
    
        let url = base_url + 'api/save_answer.php';
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json' // Specify content type
            },
            body: JSON.stringify({
                answer_date : answerDate,
                // answer_no : answerNo,
                question_id: question_id,
                start_time: start_time,
                end_time: end_time,
                is_correct: is_correct,
                score: scoreResult
            }) // Convert JavaScript object to JSON string
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json(); // Parse JSON from the response
        })
        .then(data => {
            if (data.status === 'success') {
                if (questions.length == countQues) {
                    addFinalResult(countQues);
                    document.querySelector("#continue").style.display="none";
                    document.querySelector("#backBtn").style.display="block";
                } else {
                    displayQuestions();
                }
            } else {
                console.error('Error:', data.message);
            } // Handle the data
        })
        .catch(error => {
            console.error('Error:', error); // Handle any errors
        });
});

document.querySelector(".view-results").addEventListener("click",function(){
    let solvedQuestionCount = countQues -1;
    addFinalResult(solvedQuestionCount)
});

function addFinalResult(solvedQuestionCount) {
    let score = document.getElementById("score").textContent;
    let finalScore = score.split("Score : ")[1]
    let percentage = (finalScore / totalScore) * 100;
    let scorePercentage = parseFloat(percentage.toFixed(2));
    let correctCount   = 0;
    let inCorrectCount = 0;
    const correctElement = document.querySelectorAll('.ques-circle.correct');
    const inCorrectElement = document.querySelectorAll('.ques-circle.incorrect');

    document.querySelector(".final-result").style.display = "flex";
    document.querySelector(".card").style.display = "none";
    
    document.querySelector("#solved-ques-no").innerHTML = (solvedQuestionCount) + "/" + questions.length;
    // const inCorrectCount = correctCount;
    if (correctElement) {
        correctCount = correctElement.length;
    }

    if (inCorrectElement) {
        inCorrectCount = inCorrectElement.length;
    }

    document.getElementById("remaining-time").innerHTML = document.getElementById('duration').textContent;
    document.getElementById("final-score").innerHTML = finalScore + "/" + totalScore;
    document.getElementById("main-score").innerHTML = scorePercentage + '%';
    document.getElementById("correct-answer").innerHTML = correctCount + "/" + questions.length;;
    document.getElementById("incorrect-answer").innerHTML = inCorrectCount + "/" + questions.length;;


    if (scorePercentage > 90) {
        document.getElementById("result-text").innerHTML = 'Excellence';
        document.getElementById("result-text-para").innerHTML = 'you scored higher than 90% of the people who have taken these test';
    } else if (scorePercentage > 60) {
        document.getElementById("result-text").innerHTML = 'Great';
        document.getElementById("result-text-para").innerHTML = 'you scored higher than 65% of the people who have taken these test';
    } else {
        document.getElementById("result-text").innerHTML = 'Less';
        document.getElementById("result-text-para").innerHTML = 'Try again if you still need to pass of these test';
    }
}

document.getElementById("restart").addEventListener("click",function(){
    location.reload();
});

document.getElementById("backBtn").addEventListener("click",function(){
    const url = user_base_url + "type.php?level_id=" + level_id;
    window.location.href = url; 
});

document.getElementById("continue").addEventListener("click",function(){
    document.querySelector(".final-result").style.display="none";
    document.querySelector(".card").style.display="block";
});
