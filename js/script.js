// Function to display a new message in the chat
function displayMessage(sender, content) {
    const chatMessages = document.getElementById('chat-messages');
    const messageElement = document.createElement('div');
    messageElement.innerHTML = `<strong>${sender}</strong>: ${content}`;
    chatMessages.appendChild(messageElement);
  
    // Scroll to the bottom to see the latest message
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }
  
  // Event listener for the send button
  document.getElementById('send-button').addEventListener('click', () => {
    const inputElement = document.getElementById('message-input');
    const message = inputElement.value.trim();
  
    if (message !== '') {
      // Replace 'Plant Expert' with the actual expert's name (if you have a user system)
      displayMessage('Plant Expert', message);
      inputElement.value = '';
    }
  });
  
  // Event listener for Enter key press in the input field
  document.getElementById('message-input').addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
      event.preventDefault();
      document.getElementById('send-button').click();
    }
  });


  <div id="answer"></div>

function calculate_soil_fertility($nitrogen, $phosphate, $potash) {

  // Calculate the deficit of each nutrient.
  $deficit_nitrogen = $nitrogen - 100;
  $deficit_phosphate = $phosphate - 50;
  $deficit_potash = $potash - 50;

  // Calculate the overall soil fertility.
  $soil_fertility = (min($deficit_nitrogen, $deficit_phosphate, $deficit_potash)) / 3;

  // Return the answer.
  return $soil_fertility;
}
  
$(document).ready(function() {
  // Get the answer from the PHP function.
  var answer = calculate_soil_fertility(
    document.getElementById("nitrogen").value,
    document.getElementById("phosphate").value,
    document.getElementById("potash").value
  );

  // Display the answer in the answer box.
  document.getElementById("answer").innerHTML = answer;
});

 
  