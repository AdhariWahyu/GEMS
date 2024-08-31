<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>GEMS FORM LEMBUR</title>

    <style>
.invoice-box {
    max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
}


        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: left;
            padding-left: 0px;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 40px;
            line-height: 40px;
            color: #333;

        }

        .invoice-box table tr.information table td {
            padding-bottom: 30px;
        }

        .invoice-box table tr.heading td {
            background: #ffffff;
            /* border-bottom: 1px solid #ddd; */
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
            padding-bottom: 20px;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .jumlah-box {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            background-color: #f0f0f0;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 5px;
            width: 100%;
            white-space: nowrap;
        }

        .signature-box {
            text-align: right !important;
        }

        .noin {
            text-align: right !important;
            padding-bottom: 30px !important;
            font-weight: 700;
            font-size: 28px;
        }

        .invoice-box table tr td:nth-child(1) {
            font-weight: semi-bold;
        }

        .invoice-box table tr td:nth-child(2) {
            padding-left: 10px;
        }

        .heading {
            margin-top: 15px !important;
        }

        .title {
            padding-bottom: 30px !important;
        }

        .ppp {
            width: 30% !important;
            font-weight: 500 !important;
        }

        .watermark {
            position: absolute;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 80px;
            color: rgba(12, 143, 12, 0.1);
            white-space: nowrap;
            z-index: -1;
            user-select: none;
            pointer-events: none;
        }




    </style>
</head>

<body>
    @if($form->status == 'approved')
    <div class="watermark">APPROVED</div>
@endif
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img
                                    src="https://garudasystem.com/wp-content/uploads/2024/07/Gems-Logos.png"
                                    style="width: 70%; max-width: 250px; margin-left: 0px;" />
                            </td>

                            <td class="noin">
                                <p>Surat Perintah Lembur</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="details">
                <td class="ppp">Nama </td>

                <td>: <span class="left-aligned">{{ $form->user->name }}</span></td>
            </tr>

            <tr class="details">
                <td class="ppp">Posisi </td>

                <td>: <span class="left-aligned">{{ $form->position }}</span></td>
            </tr>

            <tr class="item">
                <td class="ppp">Tanggal </td>

                <td>: <span class="left-aligned">{{ $form->date }}</span></td>
            </tr>

            <tr class="item">
                <td class="ppp">Jam Mulai </td>

                <td>: <span class="left-aligned">{{ $form->start_time }}</span></td>
            </tr>

            <tr class="item">
                <td class="ppp">Jam Selesai </td>

                <td>: <span class="left-aligned">{{ $form->end_time }}</span></td>
            </tr>

            <tr class="item">
                <td class="ppp">Durasi </td>

                <td>: <span class="left-aligned">{{ $form->duration }}</span></td>
            </tr>

            <tr class="item last">
                <td class="ppp">Pekerjaan </td>

                <td>: <span class="left-aligned">{{ $form->task_description }}</span></td>

            </tr>

            {{-- <tr class="heading">
                <td>
                    <div class="jumlah-box">
                        Jumlah &nbsp; &nbsp; &nbsp;: &nbsp; &nbsp; &nbsp; <span>{{ number_format($invoice->jumlah, 2)}}</span>
                    </div>
                </td>

                <td class="signature-box">
                    <p>Surabaya, {{ $invoice->created_at->format('d M Y') }}</p>
                    <p><br/></p>
                    <p><br/></p>

                    <p>(..........................)</p>
                </td>


            </tr> --}}

        </table>
    </div>
</body>
</html>
