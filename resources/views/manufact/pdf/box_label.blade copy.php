<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table thead tr th {
        border: 1px solid;
        margin-top: 5px;
    }

    table tbody tr td {
        border: 1px solid;
    }
</style>

<table border="0.1" cellpadding="10">
    <thead>
        <tr>
            <th>
                <img src="/home/ekspench/projet_web/logistic/public/img/scania-logo.jpg" />
            </th>
            <th align="center" colspan="3">
                <h2>SCANIA</h2>
            </th>
        </tr>
        <tr>
            <th align="center">
                <span style="font-weight: bold"> Part réference</span>
                <span style="font-weight: 100;"> Réference pièce</span>
            </th>
            <th align="center">
                <span style="font-weight: bold"> Amount in box</span>
                <span style="font-weight: 100;"> Quantité total bac</span>
            </th>
            <th align="center">
                <span style="font-weight:bold"> Batch number</span><br>
                <span style="font-weight: 100;"> N° lot</span>
            </th>
            <th align="center">
                <span style="font-weight: bold">Box number</span><br>
                <span style="font-weight: 100;">N° de caisse</span>
            </th>
        </tr>
        <tr>
            <th align="center" style="font-weight: bold">
                {{ $box->part->reference }}
            </th>
            <th align="center" style="font-weight: bold">
                {{ $box->castes->count() }}
            </th>
            <th align="center" style="font-weight: bold">
                2022
            </th>
            <th align="center" style="font-weight: bold">
                {{ $box->number }}
            </th>

        </tr>
        <tr>
            <th align="center">
                <span style="font-weight: bold">Name</span><br>
                <span style="font-weight: 100;"> Nom</span>
            </th>
            <th align="center">
                <span style="font-weight: bold">Quantity</span><br>
                <span style="font-weight: 100;"> Quantité</span>
            </th>
            <th align="center">
                <span style="font-weight: bold">Casting mark</span><br>
                <span style="font-weight: 100;"> Répère coulée</span>
            </th>
            <th align="center">
                <span style="font-weight: bold"> Date</span><br>
                <span style="font-weight: 100;"> Date</span>
            </th>

        </tr>
    </thead>
    <tbody>
        @foreach ($box->castesGroupByMark as $cast)
            <tr>
                <td align="center">
                    Jeremy PONCELET
                </td>
                <td align="center">
                    {{ $cast->quantity_cast }}
                </td>
                <td align="center">
                    @if ($cast->mark_replace)
                        {{ $cast->mark_replace }}
                    @else
                        {{ $cast->mark }}
                    @endif
                </td>
                <td align="center">
                    {{ date('d/m/Y', strtotime($cast->created_at)) }}
                </td>

            </tr>
        @endforeach

    </tbody>
</table>
<table border="0.1" cellpadding="10">
    <tbody>
        <tr>
            <td align="center" rowspan="2" style="width: 85px;">
                <span style="font-weight:bold;line-height:40px;">Full</span> <br> <span>Complet</span>
            </td>
            <td rowspan="2" align="center"
                style="width: 50px;background-color: black;color: white; font-weight: bold; font-size: 16px;line-height:60px;">
                <span>X</span>
            </td>
            <td rowspan="2" style="width: 45%;text-align: right;">
                <span style="font-weight: bold">Quantity validated By</span> <br>
                <span>Quantité validée par</span><br> <span style="font-weight: bold;">Date</span> <br>
                <span>Date</span>
            </td>
            <td style="width: 30%;text-align: right">

            </td>

        </tr>
        <tr>
            <td align="center" style="width: 30%">
                {{ date('d/m/Y') }}
            </td>

        </tr>

</table>
<table border="0.1" cellpadding="10">
    <tbody>
        <tr>
            <td align="center">
                <span style="font-weight: bold">GO Machining</span> <br>
                <span>GO Usinage</span>
            </td>
            <td style="width: 25%">

            </td>
            <td align="center">
                <span style="font-weight: bold">GO Shipping</span> <br>
                <span>GO Expedition</span>
            </td>
            <td style="width: 25%">

            </td>
        </tr>
    </tbody>
</table>
<p style="background-color: white; top:-4px">Label to put in box / Etiquette à mettre dans la caisse</p>
