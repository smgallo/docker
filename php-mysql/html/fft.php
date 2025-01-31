<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>

<div id="sinusodal"></div>
<div id="sinusodal-fft"></div>
<div id="sine"></div>
<div id="sine-fft"></div>
<div id="sine-phase"></div>
<div id="square"></div>
<div id="square-fft"></div>

<div id="fake1"></div>
<div id="fake1-fft"></div>
<div id="fake-dim1-fft"></div>
<div id="fake1-phase"></div>

<div id="fake2"></div>
<div id="fake2-fft"></div>
<div id="fake2-phase"></div>

<?php
require('vendor/autoload.php');
require('fft_class.php');

use Webit\Math\Fft\FftCalculatorRadix2;
use Webit\Math\Fft\Dimension;
use Webit\Math\ComplexNumber\ComplexArray;

/*
t = np.linspace(0, 0.5, 500)
s = np.sin(40 * 2 * np.pi * t) + 0.5 * np.sin(90 * 2 * np.pi * t)
 */

$start = 0.0;
$end = 0.5;
$num = 500.0;
$step = $end/$num;
$freq = 1/$step;

print "Interval = $step, freq = $freq\n";

$freq1 = 40;
$freq2 = 90;
$pi = 3.14159265359;

$sinusodal = [];
$time = [];

for ($i = $start; $i <= $end+$step; $i += $step) {
    $time[] = $i;
    $sinusodal[] = sin($freq1 * 2 * $pi * $i) + 0.5 * sin($freq2 * 2 * $pi * $i);
}

$sine = [];
$degrees = 0;

for ($i = $start; $i <= $end+$step; $i += $step) {
    if ($degrees > 360) {
        $degrees = 0;
    }
    $sine[] = sin(deg2rad($degrees));
    $degrees+=10;
}

$square = [];
$value = 0;
$count = 0;

for ($i = $start; $i <= $end+$step; $i += $step) {
    if ($count % 10 == 0) {
        $value = ($value ? 0 : 1);
        $count = 0;
    }
    $square[] = $value;
    $count++;
}

$f = [];
$step = $freq/$num;
for ($i=0; $i <= $freq; $i += $step) {
    $f[] = $i;
}

list($sinusodal_real, $sinusodal_imaginary) = FFT::run($sinusodal);
list($sine_real, $sine_imaginary) = FFT::run($sine);
list($square_real, $square_imaginary) = FFT::run($square);

$sinusodal_amplitude = array_map(
    function ($item) use ($num) {
        return abs($item) * 1/$num;
    },
    $sinusodal_real
);

$sine_amplituede = array_map(
    function ($item) use ($num) {
        return abs($item) * 1/$num;
    },
    $sine_real
);
$threshold = 100;
$sine_phase = array_map(
    function ($item) use ($threshold) {
        return (abs($item) < $threshold ? 0 : rad2deg($item));
    },
    $sine_imaginary
);

$square_amplitude = array_map(
    function ($item) use ($num) {
        return abs($item) * 1/$num;
    },
    $square_real
);

$fake_data_1 = [];
$degrees = 0;

for ($i = $start; $i <= $end+$step; $i += $step) {
    if ($degrees > 360) {
        $degrees = 0;
    }
    $sine[] = sin(deg2rad($degrees));
    $degrees+=10;
}

$fake_data_1 = [ 10, 10, 10, 10, 10, 10, 10, 10 ];
$fake_data_1 = [ 10, 9, 10, 9, 10, 9, 10, 9 ];
$fake_data_1 = [ 8, 10, 10, 8, 7, 6, 8, 8, 8, 6, 10, 10, 10 ];
$fake_data_1 = [ 10, 10, 10, 10, 7, 3, 0, 0, 0, 6, 10, 10, 10 ];
print "AVG: " . array_sum($fake_data_1)/count($fake_data_1) . "<br>";

$num = count($fake_data_1);
list($real, $imaginary) = FFT::run($fake_data_1);
$fake_amplitude_1 = array_map(
    function ($item) use ($num) {
        return abs($item) * 1/$num;
    },
    $real
);
$threshold = 100;
$fake_phase_1 = array_map(
    function ($item) use ($threshold) {
        return rad2deg($item); // (abs($item) < $threshold ? 0 : rad2deg($item));
    },
    $imaginary
);

$fake_data_2 = [ 10, 10, 7, 3, 0, 0, 0, 6, 10, 10, 5, 2, 2, 8, 9, 6, 5, 1, 5, 10, 10, 7, 3, 0, 0, 0, 6, 10, 10, 5, 2, 2, 8, 9, 6, 5, 1 ];
$fake_data_2 = [ 10, 10, 7, 6, 7, 6, 3, 3, 4, 5, 2, 2, 3, 2, 3, 8, 9, 8, 7, 7 ];
$fake_data_2 = array_map(
    function ($item) {
        return $item;
    },
    $fake_data_2
);
$num = count($fake_data_2);
list($real, $imaginary) = FFT::run($fake_data_2);
$fake_amplitude_2 = array_map(
    function ($item) use ($num) {
        return abs($item);
    },
    $real
);
$threshold = 10;
$fake_phase_2 = array_map(
    function ($item) use ($threshold) {
        return (abs($item) < $threshold ? 0 : rad2deg($item));
    },
    $imaginary
);


$calculator = new FftCalculatorRadix2();
$signal = ComplexArray::create($sine);
$fft = $calculator->calculateFft($signal, Dimension::create(32));

$fake_dim1_real = [];
foreach ($fft as $item) {
    $fake_dim1_real[] = abs($item->getReal());
}
?>

<script>
    var data = [{
        x: [<?= implode(',', $time) ?>],
        y: [<?= implode(',', $sinusodal) ?>],
        type: 'scatter'
    }];

    Plotly.newPlot(
        'sinusodal',
        data,
        {
            title: 'Sinusodal',
            xaxis: {
                title: 'Time'
            },
            yaxis: {
                title: 'Amplitude'
            }
        }
    );

    var real = [{
        x: [<?= implode(',', array_keys($f)) ?>],
        y: [<?= implode(',', $sinusodal_amplitude) ?>],
        type: 'bar'
    }];

    Plotly.newPlot('sinusodal-fft', real);

    var data = [{
        x: [<?= implode(',', $time) ?>],
        y: [<?= implode(',', $sine) ?>],
        type: 'scatter'
    }];

    Plotly.newPlot(
        'sine',
        data,
        {
            title: 'Sine',
            xaxis: {
                title: 'Time'
            },
            yaxis: {
                title: 'Amplitude'
            }
        }
    );

    var real = [{
        x: [<?= implode(',', array_keys($f)) ?>],
        y: [<?= implode(',', $sine_amplituede) ?>],
        type: 'bar'
    }];

    Plotly.newPlot('sine-fft', real);

    var imaginary = [{
        x: [<?= implode(',', array_keys($f)) ?>],
        y: [<?= implode(',', $sine_phase) ?>],
        type: 'bar'
    }];

    Plotly.newPlot('sine-phase', imaginary, { title: 'Sine Phase' });

    // ----------

    var data = [{
        x: [<?= implode(',', array_keys($f)) ?>],
        y: [<?= implode(',', $square) ?>],
        type: 'scatter'
    }];

    Plotly.newPlot(
        'square',
        data,
        {
            title: 'Square',
            xaxis: {
                title: 'Time'
            },
            yaxis: {
                title: 'Amplitude'
            }
        }
    );

    var real = [{
        x: [<?= implode(',', array_keys($f)) ?>],
        y: [<?= implode(',', $square_amplitude) ?>],
        type: 'bar'
    }];

    Plotly.newPlot('square-fft', real);

    // ----------

    var data = [{
        x: [<?= implode(',', array_keys($fake_data_1)) ?>],
        y: [<?= implode(',', $fake_data_1) ?>],
        type: 'scatter'
    }];

    Plotly.newPlot(
        'fake1',
        data,
        {
            title: 'Fake 1',
            xaxis: {
                title: 'Time'
            },
            yaxis: {
                title: 'Amplitude'
            }
        }
    );

    var real = [{
        x: [<?= implode(',', array_keys($fake_data_1)) ?>],
        y: [<?= implode(',', $fake_amplitude_1) ?>],
        type: 'bar'
    }];

    Plotly.newPlot('fake1-fft', real);

    var real = [{
        x: [<?= implode(',', array_keys($fake_dim1_real)) ?>],
        y: [<?= implode(',', $fake_dim1_real) ?>],
        type: 'bar'
    }];

    Plotly.newPlot('fake-dim1-fft', real, { title: 'Using dimensions' });


    var imaginary = [{
        x: [<?= implode(',', array_keys($fake_phase_1)) ?>],
        y: [<?= implode(',', $fake_phase_1) ?>],
        type: 'bar'
    }];

    Plotly.newPlot('fake1-phase', imaginary, { title: 'Fake 1 phase' });

    // ----------

    var data = [{
        x: [<?= implode(',', array_keys($fake_data_1)) ?>],
        y: [<?= implode(',', $fake_data_1) ?>],
        type: 'scatter'
    }];

    Plotly.newPlot(
        'fake1',
        data,
        {
            title: 'Fake 1',
            xaxis: {
                title: 'Time'
            },
            yaxis: {
                title: 'Amplitude'
            }
        }
    );

    var real = [{
        x: [<?= implode(',', array_keys($fake_data_1)) ?>],
        y: [<?= implode(',', $fake_amplitude_1) ?>],
        type: 'bar'
    }];

    Plotly.newPlot('fake1-fft', real);


    // ----------

    var data = [{
        x: [<?= implode(',', array_keys($fake_data_2)) ?>],
        y: [<?= implode(',', $fake_data_2) ?>],
        type: 'scatter'
    }];

    Plotly.newPlot(
        'fake2',
        data,
        {
            title: 'Fake 2',
            xaxis: {
                title: 'Time'
            },
            yaxis: {
                title: 'Amplitude'
            }
        }
    );

    var real = [{
        x: [<?= implode(',', array_keys($fake_data_2)) ?>],
        y: [<?= implode(',', $fake_amplitude_2) ?>],
        type: 'bar'
    }];

    Plotly.newPlot('fake2-fft', real);

    var imaginary = [{
        x: [<?= implode(',', array_keys($fake_phase_2)) ?>],
        y: [<?= implode(',', $fake_phase_2) ?>],
        type: 'bar'
    }];

    Plotly.newPlot('fake2-phase', imaginary, { title: 'Fake 2 phase' });
</script>
<body>

  <div id="console"></div>
</body>
