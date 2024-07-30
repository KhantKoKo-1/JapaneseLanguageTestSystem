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

function displayQuestions() {
    document.getElementById("ques-left").textContent="Question : "+(countQues+1)+"/"+questions.length;
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
                        <input type="radio" class="btn-check" style="width: 100%;" name="options-outlined" id="success-outlined_${choiceIndex}" autocomplete="off" checked>
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
//     alert(window[lang][countQues].choices[window[lang][countQues].answer-1]);
//     alert(document.querySelector('input[name="options"]:checked').value);
        if (questions.length == countQues) {
            alert('ho')
        } else {

            displayQuestions();
        }
        // score-=5;
        // document.getElementById("score").textContent="Score : "+score;
        // document.getElementById("ques-view").innerHTML+="<div class='ques-circle incorrect'>"+(countQues+1)+"</div>";

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
