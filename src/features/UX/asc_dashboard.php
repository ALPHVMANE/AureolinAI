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

    <link rel="stylesheet" href="/WEBAPPPROJECT/templates/styles/asc_style.css">
    <script src="/WEBAPPPROJECT/templates/js/asc_script.js"></script>
    <style>
        body {
            background-color: #2b2e35;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .dashboard-widgets {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 40px;
            margin: 60px auto;
            max-width: 1100px;
            padding: 0 20px;
        }

        .widget {
            background-color: #444;
            color: white;
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            min-width: 280px;
            flex: 1;
        }

        .xp-bar {
            width: 100%;
            height: 8px;
            background-color: #ccc;
            border-radius: 10px;
            overflow: hidden;
            margin: 10px 0;
        }

        .xp-progress {
            height: 100%;
            background-color: #fbc02d;
            width: <?php echo min(100, ($xp % 100)); ?>%
        }

        .quiz button {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            font-size: 16px;
            cursor: pointer;
            border-radius: 6px;
            border: none;
        }

        .correct { background-color: #4CAF50; }
        .wrong { background-color: #f44336; }

        .streak {
            font-size: 20px;
            font-weight: bold;
            color: #FFD700;
            text-align: center;
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