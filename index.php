<!DOCTYPE html>
<html>

<head>
    <title>Calculator</title>
    <style>
        * {
            font-family: 'Helvetica Neue', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #363635;
        }

        main {
            width: 393px;
            height: 852px;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            padding: 20px;
            background-color: #000;
        }

        .display {
            flex: 1;
            color: #fff;
            font-size: 2em;
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        .button {
            background-color: #363635;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90px;
            width: 90px;
            font-size: 1.5em;
            border-radius: 45px;
            cursor: pointer;
            user-select: none;
            color: #fff;
        }

        .button:active {
            background-color: gray;
        }

        .top {
            background-color: #a3a3a1;
        }

        .operation {
            background-color: #e09c4c;
        }
    </style>
</head>

<body>

    <main>
        <div class="display">
            <span id="display"></span>
        </div>
        <div class="buttons">
            <div class="button top" onclick="clearDisplay()">AC</div>
            <div class="button top" onclick="appendToDisplay('+/-')">+/-</div>
            <div class="button top" onclick="appendToDisplay('%')">%</div>
            <div class="button operation" onclick="appendToDisplay('/')">÷</div>
            <div class="button" onclick="appendToDisplay('7')">7</div>
            <div class="button" onclick="appendToDisplay('8')">8</div>
            <div class="button" onclick="appendToDisplay('9')">9</div>
            <div class="button operation" onclick="appendToDisplay('*')">×</div>
            <div class="button" onclick="appendToDisplay('4')">4</div>
            <div class="button" onclick="appendToDisplay('5')">5</div>
            <div class="button" onclick="appendToDisplay('6')">6</div>
            <div class="button operation" onclick="appendToDisplay('-')">−</div>
            <div class="button" onclick="appendToDisplay('1')">1</div>
            <div class="button" onclick="appendToDisplay('2')">2</div>
            <div class="button" onclick="appendToDisplay('3')">3</div>
            <div class="button operation" onclick="appendToDisplay('+')">+</div>
            <div class="button">?</div>
            <div class="button" onclick="appendToDisplay('0')">0</div>
            <div class="button" onclick="appendToDisplay('.')">,</div>
            <div class="button operation" onclick="calculate()">=</div>
        </div>
    </main>

    <form id="calculator-form" method="POST" style="display: none;">
        <input type="hidden" name="num1" id="num1">
        <input type="hidden" name="operation" id="operation">
        <input type="hidden" name="num2" id="num2">
    </form>

    <script>
        let display = document.getElementById('display');
        let num1 = '';
        let num2 = '';
        let operation = '';

        function clearDisplay() {
            display.textContent = '';
            num1 = '';
            num2 = '';
            operation = '';
        }

        function appendToDisplay(value) {
            display.textContent += value;
        }

        function calculate() {
            const displayValue = display.textContent;
            const match = displayValue.match(/(\d+)([\+\-\*\/])(\d+)/);

            if (match) {
                num1 = match[1];
                operation = match[2];
                num2 = match[3];

                document.getElementById('num1').value = num1;
                document.getElementById('operation').value = operation;
                document.getElementById('num2').value = num2;

                document.getElementById('calculator-form').submit();
            } else {
                alert('Invalid input');
            }
        }
    </script>

    <?php
    class Calculator
    {
        public function calculate($num1, $num2, $operation)
        {
            switch ($operation) {
                case '+':
                    return $num1 + $num2;
                case '-':
                    return $num1 - $num2;
                case '*':
                    return $num1 * $num2;
                case '/':
                    if ($num2 != 0) {
                        return $num1 / $num2;
                    } else {
                        throw new Exception("Error: Division by zero!");
                    }
                default:
                    throw new Exception("Invalid operation!");
            }
        }
    }

    $calculator = new Calculator();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $num1 = (float) $_POST['num1'];
        $operation = $_POST['operation'];
        $num2 = (float) $_POST['num2'];

        try {
            $result = $calculator->calculate($num1, $num2, $operation);
            echo "<script>document.getElementById('display').textContent = '$result';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
    ?>
</body>

</html>
