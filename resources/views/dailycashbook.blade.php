<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{public_path('styles/dailycashbook.css')}}">
        <title>Daily Cashbook</title>
    </head>
    <body>
        <div id = "header">
            <div id="header-title">PERE'S BAKERY DAILY CASHBOOK</div>
        </div>
        <div id = "reportbody">
            <table>
                <thead>
                    <tr>
                        <th colspan="5" class ="level-2-header" id = "acc-no">A/C N0:</th>
                        <th> </th>
                        <th colspan="6" class ="level-2-header" id = "sub-title">DAILY A/C</th>
                    </tr>
                    <tr>
                        <td colspan ="12"> DAILY CASHBOOK</td>
                    </tr>
                    <tr>
                        <td>DATE</td>
                        <td>PARTICULARS</td>
                        <td>CHQ/FOLIO</td>
                        <td>CASH</td>
                        <td>CARD/TRANSFERS</td>
                        <td>TOTAL</td>
                        <th>DATE</th>
                        <th>PARTICULARS</th>
                        <th>CHQ/FOLIO</th>
                        <th>CASH</th>
                        <th>BANK</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @for($k = 0; $k < $motherArray['size'], $k++)
                    <tr>
                        <td>$motherArray['date']</td>
                        <td></td>
                        <td></td>
                        <td>$motherArray['cash_sales'][$k]->amount</td>
                        <td>$motherArray['bank_sales'][$k]->amount</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        @if(count($motherArray['expenses']) >0)
                            <td>$motherArray['expenses'][0]->amount</td>
                        @else
                            <td></td>
                        @endif
                        <td></td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </body>
</html>