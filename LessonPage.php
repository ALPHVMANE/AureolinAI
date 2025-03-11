<div class="lesson">
    <h3>Translate: "Hello"</h3>
    <button onclick="checkAnswer(this)" data-correct="true">Hola</button>
    <button onclick="checkAnswer(this)">Bonjour</button>
    <button onclick="checkAnswer(this)">Hallo</button>
</div>

<script>
    function checkAnswer(button) {
        if (button.getAttribute("data-correct") === "true") {
            alert("✅ Correct!");
        } else {
            alert("❌ Try again!");
        }
    }
</script>
