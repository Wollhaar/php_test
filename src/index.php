<?php

$form = $_POST;
// continues....

// the for loop for output hello and world
for($i = 0; $i = 100; $i++) {
    if (!is_float($i / 3)) {
        echo 'Hello';
    }
    elseif (!is_float($i / 5)) {
        echo 'World';
    }
    else {
        echo $i;
    }
}

?>

<html>
<head>
</head>
<body>
<div class="wrapper" style=".wrapper{margin: auto; width 300px;}">
    <h2>Ausgabe von 'Hello' und 'World'.</h2>
    <p>Mit variablen Zahlen. Die Ausgabe wird in einem Bereich gezählt werden, den Sie ausgewählt haben.
        Zudem dürfen Sie auch die Zahlen aussuchen durch welche Zahlen die beiden Wörter ausgeworfen werden sollen.</p>
<!--  Auswahl  -->
    <?php if (empty($form)): ?>
    <div class="form_element">
        <form action="#" method="post">
            <input type="hidden" name="form" value="1">
            <label for="amount"><b>Die Counterarea</b> - zwischen welchen Zahlen darf gezählt werden?</label>
            <input type="text" name="amount" id="amount" /><br/><br/>
            <label for="ouput_hello"><b>Die Dividende für 'Hello'</b></label>
            <input type="text" name="output_hello" id="ouput_hello" /><br/><br/>
            <label for="output_world"><b>Die Dividende für 'World'</b></label>
            <input type="text" name="output_world" id="output_world" /><br/><br/>
            <button type="submit">Starten</button>
        </form>
    </div>
<!--     Ausgabe     -->
    <?php elseif ($form == 1): ?>
    <div class="output">
        <?php foreach ($output as $value): ?>
        <span><?php echo $value; ?></span><br/>
        <?php endforeach; ?>

<!--    von neu starten    -->
        <p>Neu starten?</p>
        <form action="#?counter=restart" method="post">
            <input type="hidden" name="restart" value="1" />
            <button type="submit">Reset</button>
        </form>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
