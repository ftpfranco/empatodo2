<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comprobante</title>
    <style>
        * {
            font-size: 12px;
            font-family: 'Times New Roman';
        }

        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
        }

        td.description,
        th.description {
            width: 75px;
            max-width: 75px;
        }

        td.quantity,
        th.quantity {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }

        td.price,
        th.price {
            width: 40px;
            max-width: 40px;
            word-break: break-all;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: 155px;
            max-width: 155px;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }

    </style>
</head>

<body>
    <div class="ticket">
        <img data="900x900" src="https://yt3.ggpht.com/-3BKTe8YFlbA/AAAAAAAAAAI/AAAAAAAAAAA/ad0jqQ4IkGE/s900-c-k-no-mo-rj-c0xffffff/photo.jpg" alt="Logo"> 
        <p class="centered">EMPRESA
            <br>{{date("Y-m-d H:i")}}
        </p>
        <table>
            <thead>
                <tr>
                    <th class="quantity">Cant.</th>
                    <th class="description">Descripcion</th>
                    <th class="price">$</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detalles as $item)
                <tr>
                    <td class="quantity">{{$item["cantidad"]}}</td>
                    <td class="description">{{substr($item["articulo"],0,8) }}  </td>
                    <td class="price">{{$item["subtotal"]}}</td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
        <p class="centered">GRACIAS POR SU COMPRA! </p>
    </div>
    {{-- <button id="btnPrint" class="hidden-print">Print</button> --}}
    {{-- <script>
        const $btnPrint = document.querySelector("#btnPrint");
        $btnPrint.addEventListener("click", () => {
            window.print();
        });
    </script> --}}
</body>

</html>
