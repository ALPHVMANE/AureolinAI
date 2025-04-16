<?php
session_start();
$username = $_SESSION['username'] ?? 'Guest';
$xp = 420;

// Word of the Day
$words = [
    ['word' => 'Maison', 'translation' => 'House'],
    ['word' => 'Chien', 'translation' => 'Dog'],
    ['word' => 'Bonjour', 'translation' => 'Hello'],
    ['word' => 'Merci', 'translation' => 'Thank you'],
    ['word' => 'École', 'translation' => 'School']
];
$dayIndex = date('z') % count($words);
$wordOfTheDay = $words[$dayIndex];

// Daily Challenge
$challenges = [
    "Translate 5 new words today.",
    "Practice for 10 minutes.",
    "Try saying today’s word out loud!",
    "Explain a word to someone IRL.",
    "Review your last lesson."
];
$challenge = $challenges[date('z') % count($challenges)];

// Language Tips
$tips = [
    "In French, all nouns have a gender.",
    "French is spoken on 5 continents.",
    "Accents matter in French spelling.",
    "Most French verbs follow regular patterns.",
    "Learning French boosts your memory!"
];
$tip = $tips[date('z') % count($tips)];

// Fun Language Fact
$facts = [
    "“Pain” means bread in French — not suffering 😅",
    "The French word for 'gift' is 'cadeau'.",
    "‘Baguette’ also means ‘wand’ in French!",
    "In French, 'chat' means cat 🐱.",
    "‘Vin’ is wine 🍷, not vinegar!"
];
$fact = $facts[date('z') % count($facts)];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aureolin - Home</title>

    <link rel="stylesheet" href="../../../templates/styles/asc_navbar.css">
    <link rel="stylesheet" href="../../../templates/styles/asc_widget.css">
    <script src="../../../templates/js/UX/asc_script.js"></script>
    
    <style>
        body {
            background-color: #ddd498;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>

<?php include 'asc_navbar.php'; ?>

<div class="dashboard-widgets">
    <!-- Welcome + XP -->
    <div class="widget">
        <h2>Welcome back, <?php echo htmlspecialchars($username); ?> 👋</h2>
        <p>You’ve earned <strong><?php echo $xp; ?> XP</strong> so far.</p>
        <div class="xp-bar"><div class="xp-progress"></div></div>
        <p>Level <?php echo floor($xp / 100) + 1; ?></p>
        <div class="streak" id="streakDisplay">🔥 Loading streak...</div>
    </div>

    <!-- Word of the Day -->
    <div class="widget">
        <h3>📖 Word of the Day</h3>
        <p><strong><?php echo $wordOfTheDay['word']; ?></strong> — "<?php echo $wordOfTheDay['translation']; ?>"</p>
    </div>

    <!-- Daily Challenge -->
    <div class="widget">
        <h3>🏆 Daily Challenge</h3>
        <p><?php echo $challenge; ?></p>
    </div>

    <!-- Did You Know -->
    <div class="widget">
        <h3>💡 Did You Know?</h3>
        <p><?php echo $tip; ?></p>
    </div>

    <!-- Fun Fact -->
    <div class="widget">
        <h3>🎉 Fun French Fact</h3>
        <p><?php echo $fact; ?></p>
    </div>

    <!-- Mini Quiz -->
    <div class="widget quiz">
        <h3>🧠 Quick Quiz</h3>
        <p>What does <strong>"Bonjour"</strong> mean?</p>
        <button onclick="checkAnswer(this, false)">Goodbye</button>
        <button onclick="checkAnswer(this, true)">Hello</button>
        <button onclick="checkAnswer(this, false)">Please</button>
        <button onclick="checkAnswer(this, false)">Bread</button>
    </div>
</div>

<?php include 'asc_footer.php'; ?>

<script>
// 🔥 Streak Tracker
(function streakTracker() {
    const today = new Date().toDateString();
    let last = localStorage.getItem('lastLogin');
    let streak = parseInt(localStorage.getItem('streak')) || 0;

    if (last !== today) {
        const yesterday = new Date();
        yesterday.setDate(yesterday.getDate() - 1);

        if (last === yesterday.toDateString()) {
            streak++;
        } else {
            streak = 1;
        }

        localStorage.setItem('streak', streak);
        localStorage.setItem('lastLogin', today);
    }

    document.getElementById("streakDisplay").innerText = `🔥 ${streak}-day learning streak`;
})();

// ✅ Mini Quiz Handler
function checkAnswer(btn, correct) {
    const buttons = btn.parentElement.querySelectorAll("button");
    buttons.forEach(b => {
        b.disabled = true;
        b.style.opacity = 0.6;
    });

    btn.classList.add(correct ? "correct" : "wrong");
    btn.innerText += correct ? " ✅" : " ❌";
}
</script>

</body>
</html>