<style>
    table{
        
    }
    table thead tr th{
        border: 1px solid;
        border-color: gray;
        margin-top: 5px;
    }
    table tbody tr td{
        border: 1px solid;
        border-color: gray;
    }
    .check{
        width: 15px;
        height: 15px;
        border: 1px solid;
        border-radius: 4px;
        border-color: gray;
        margin:auto;

    }
</style>

<div>
    <h3 style="text-align: center;font-size: 22px; font-weight: bold;">Fiche de controle</h3>
    <h6 style="font-size: 22px; margin: 0; font-weight: bold;">Réference pièce: {{ $box->part->reference }}</h6>
    <h6 style="font-size: 22px; margin: 0; font-weight: bold;">Numero de caisse: {{ $box->number }}</h6>
    <h6 style="font-size: 22px; margin: 0; font-weight: bold;">Ref: #{{ $box->ref }}</h6>

    <table width="100%" border="0.5" style="font-weight: bold; font-size: 12pt; border-collapse: collapse;margin-top: 5px;"  cellpadding="2">
        <thead>
            <tr style="background-color: rgb(174, 238, 250)">
                <th width="3%" style="text-align:center">N°</th>
                <th width="15%" style="text-align:center">Repère de coulée</th>
                <th style="text-align:center">Poinçon </th>
                <th style="text-align:center">Tampon</th>
                <th style="text-align:center">Conforme</th>
                <th style="text-align:center">Rebut</th>
                <th style="text-align:center">Réparation</th>
                <th style="text-align:center">Contrôle RX</th>
                <th style="text-align:center">Contrôle US</th>
                <th width="15%" style="text-align:center">Remplacement</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($box->castes as$key=>$cast)
                <tr @if ($key%2==0)
                 style="background-color: rgb(255, 255, 255)"
                    @else
                    style="background-color: rgb(238, 237, 237)"
                @endif >
                    <td width="3%" style="text-align:center">{{ $cast->number }}</td>
                    <td width="15%" style="text-align:center">{{ $cast->mark }}</td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"> <div class="check"></div></td>
                    <td style="text-align:center"><div class="check"></div></td>
                    <td style="text-align:center"><div class="check"></div></td>
                    <td style="text-align:center"> <div class="check"></div></td>
                    <td style="text-align:center"><div class="check"></div> </td>
                    <td width="15%" style="text-align:center"></td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
