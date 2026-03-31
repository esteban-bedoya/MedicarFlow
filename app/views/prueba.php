<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/MedicarFlow/public/assets/libs/bootstrap/bootstrap.min.css">
    <script src="/MedicarFlow/public/assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
</head>

<body>
    <h1>1. Prueba del Bootstrap</h1>
    <button class="btn btn-primary">Prueba Bootstrap</button>

    <h1>2. Prueba de Chart.js</h1>
    <canvas id="testChart" width="400" height="200"></canvas>
    <script src="/MedicarFlow/public/assets/libs/chartjs/chart.umd.min.js"></script>

    <script>
        const ctx = document.getElementById('testChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['A', 'B', 'C'],
                datasets: [{
                    label: 'Test',
                    data: [5, 10, 7]
                }]
            }
        });
    </script>

    <h1>3. Prueba de Sweetalert2</h1>
    <script src="/MedicarFlow/public/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
    <script>
        Swal.fire({
            title: '¡Funciona!',
            text: 'SweetAlert2 está integrado correctamente',
            icon: 'success',
            confirmButtonText: 'Genial'
        });
    </script>


</body>

</html>