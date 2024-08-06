//function myfunc(){
//    alert(document.getElementById("language").value);
//}

var countQues = 0;
var lang;
var score = 0;

        
window.addEventListener('DOMContentLoaded', (event) => {
    // Example: Log each description and its corresponding question details
    displayQuestions();
})

const answer_no = "";

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
    document.getElementById("ques-left").textContent="Question : "+(countQues+1)+"/"+questions.length;
    document.getElementById("question_id").value = questions[countQues].question_id;
    document.getElementById("start_time").innerHTML = getCurrentDateTime();
    document.querySelector(".question").innerHTML="<h1>"+questions[countQues].question+"</h1>";
    displayChoices(countQues);
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
// //alert(questions.length);
// document.getElementById("score").textContent="Score : "+0;
// document.querySelector(".view-results").style.display="none";
// // document.querySelector(".quiz").style.display="none";
// document.querySelector(".final-result").style.display="none";





document.querySelector(".submit-answer").addEventListener("click",function(){
    let question_id = document.getElementById("question_id").value;
    let start_time  = document.getElementById("start_time").textContent;
    let end_time    = getCurrentDateTime();
    let is_correct  = false;
    const selectedChoice = document.querySelector('input[name="options-outlined"]:checked');
    
    if (selectedChoice) {
        if (selectedChoice.value == questions[countQues-1].answer) {
            is_correct = true;
            document.getElementById("score").textContent = "Score : " + questions[countQues-1].score;
        }
    }
    
    let url = base_url + 'api/answer_api.php';
    console.log(typeof(question_id))
    console.log(typeof(start_time))
    console.log(typeof(end_time))
    console.log(typeof(is_correct))
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json' // Specify content type
        },
        body: JSON.stringify({
            question_id: question_id,
            start_time: start_time,
            end_time: end_time,
            is_correct: is_correct
        }) // Convert JavaScript object to JSON string
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json(); // Parse JSON from the response
    })
    .then(data => {
        console.log(data); // Handle the data
    })
    .catch(error => {
        console.error('Error:', error); // Handle any errors
    });
      

    if (questions.length == countQues) {
        // alert(questions[0].score)
    } else {
        displayQuestions();
    }
});

document.querySelector(".view-results").addEventListener("click",function(){
    
    document.querySelector(".final-result").style.display="block";
    
    document.querySelector(".solved-ques-no").innerHTML="You Solved "+(countQues+1)+" questions of "+document.getElementById("language").value;
    
    var correct= document.getElementById("ques-view").getElementsByClassName("correct").length;
    
    document.querySelector(".right-wrong").innerHTML=correct+" were Right and "+((countQues+1)-correct)+" were Wrong";
    
    document.getElementById("display-final-score").innerHTML="Your Final Score is: "+score;
    
    if (correct/(countQues+1)>0.8){
        document.querySelector(".remark").innerHTML="Remark: OutStanding ! :)";
    }else if(correct/(countQues+1)>0.6){
        document.querySelector(".remark").innerHTML="Remark: Good, Keep Improving.";
    
    }else if(correct/(countQues+1)){
        document.querySelector(".remark").innerHTML="Remark: Satisfactory, Learn More.";
    }else{
        document.querySelector(".remark").innerHTML="Remark: Unsatisfactory, Try Again.";
    }
    
//    window.location.href="#display-final-score";

});

document.getElementById("restart").addEventListener("click",function(){
    location.reload();

});

// document.getElementById("about").addEventListener("click",function(){
//     alert("Quiz Website Project Created By Digvijay Singh");

// });


/*Smooth Scroll*/


$(document).on('click', 'a[href^="#"]', function (event) {
    event.preventDefault();

    $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top
    }, 1000);
});



/*Smooth Scroll End*/
