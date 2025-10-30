<!DOCTYPE html>
<html lang="tk">
<head>
    <meta charset="UTF-8">
    <title>Bank Kartyny almak üçin Onlaýn Arza-Anketa</title>
    <style>
        body {
            margin: 0;
            padding: 15mm;
            color: #000;
            background-color: #fff;
            font-size: 10pt;
            font-family: DejaVu Sans, sans-serif;
        }
        table {
            border-collapse: collapse;
        }
        .container {
            width: 100%;
            max-width: 550px;
            margin: 0 auto;
        }
        .section-header {
            font-weight: bold;
            font-size: 12pt;
            margin-top: 25px;
            margin-bottom: 15px;
            padding: 3px 6px;
            border: 1px solid #000;
            white-space: nowrap;
        }
        .agreement-text {
            font-size: 11pt;
            line-height: 1.5;
            margin: 20px 0 15px 0;
            padding: 5px 0;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            height: 17px;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- HEADER -->
    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 25px;">
        <tr>
            <td style="text-align: center; padding-top: 5px;">
                <div style="font-weight: bold; font-size: 10pt;">TÜRKMENISTANYŇ «SENAGAT» PAÝDARLAR TÄJIRÇILIK BANKY</div>
                <div style="font-size: 9pt; margin-top: 3px;">Bank kartyny almak üçin <span style="text-decoration: underline;">Onlaýn</span> Arza-Anketa</div>
            </td>
            @foreach($orders as $order)
                <td style="text-align: center; font-size: 12pt; padding-top: 5px; white-space: nowrap;">
                    <strong>{{ $order->cardType->getTranslation('title', 'tk') }}</strong><br>Bank karty
                </td>
            @endforeach
        </tr>
    </table>

    <!-- CARD INFO -->
    <div class="card-info">
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 2px;">
            <tr>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; width: 200px; vertical-align: bottom;">Kartyň görnüşi:</td>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom;">{{ $order->cardType->getTranslation('title', 'tk') }}</td>
                @endforeach
            </tr>
        </table>

        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 2px;">
            <tr>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; width: 200px; vertical-align: bottom;">Kartyň işleşiniň tertibi:</td>
                <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom;">Debit karty</td>
            </tr>
        </table>

        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 2px;">
            <tr>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; width: 200px; vertical-align: bottom;">Kart hasabynyň pul birligi:</td>
                <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom;">TMT</td>
            </tr>
        </table>
    </div>

    <div class="section-header">
        1. Şahsy maglumatlar <span style="font-size: 12pt; font-weight: normal;">(Müşderi tarapyndan doldurylýar)</span>
    </div>

    <!-- PERSONAL INFO -->
    <div class="personal-info">
        <!-- Name Row -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
            <tr>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom; width: 22%;">Familiýasy:</td>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom; width: 28%;">{{ $order->profile->last_name }}</td>
                @endforeach
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom; width: 10%;">Ady:</td>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom; width: 40%;">{{ $order->profile->first_name }}</td>
                @endforeach
            </tr>
        </table>

        <!-- Father's Name and Birth Date -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
            <tr>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom; width: 22%;">Atasynyň ady:</td>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom; width: 28%;">{{ $order->profile->middle_name }}</td>
                @endforeach
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom; width: 20%;">Doglan senesi:</td>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom; width: 30%;">{{ \Carbon\Carbon::parse($order->profile->birth_date)->format('d/m/Y') }}</td>
                @endforeach
            </tr>
        </table>

        <!-- Citizenship and Gender -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
            <tr>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom; width: 22%;">Raýatlygy:</td>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom; width: 28%;">{{ $order->profile->citizenship }}</td>
                @endforeach
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom; width: 15%;">Jynsy:</td>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom; width: 35%;">{{ $order->profile->gender }}</td>
                @endforeach
            </tr>
        </table>

        <!-- Passport Info -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
            <tr>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom; width: 22%;">Pasport seriýasy:</td>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom; width: 15%;">{{ $order->profile->passport_number }}</td>
                @endforeach
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom; width: 13%;">belgisi:</td>
                <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom; width: 15%;">703879</td>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom; width: 15%;">berlen senesi:</td>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom; width: 20%;">{{ \Carbon\Carbon::parse($order->profile->issued_data)->format('d/m/Y') }}</td>
                @endforeach
            </tr>
        </table>

        <!-- Issued By -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
            <tr>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom;">Kim tarapyndan berlen:</td>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom;">{{ $order->profile->issued_by }}</td>
                @endforeach
            </tr>
        </table>

        <!-- Registered Address -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
            <tr>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom;">Ýazgyda duran salgysy:</td>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom;">{{ $order->profile->home_address }}</td>
                @endforeach
            </tr>
        </table>

        <!-- Actual Address -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
            <tr>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom;">Hakyky ýaşaýan ýeri:</td>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom;">{{ $order->profile->home_address }}</td>
                @endforeach
            </tr>
        </table>

        <!-- Phones and Secret Word -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
            <tr>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom; width: 15%;">Öý telefon:</td>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom; width: 20%;">{{ $order->profile->home_phone }}</td>
                @endforeach
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom; width: 18%;">Öýjükli telefon:</td>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom; width: 20%;">{{ $order->phone_number }}</td>
                @endforeach
                <td style="text-align: center; vertical-align: bottom; width: 27%;">
                    @foreach($orders as $order)
                        <div style="font-size: 10pt; padding: 0 2px; border-bottom: 1px solid #000; margin-bottom: 1px;">{{ $order->profile->last_name }}</div>
                    @endforeach
                    <div style="font-size: 7pt;">Sorag-jogap gullugyna aýdylýan gizlin söz</div>
                </td>
            </tr>
        </table>

        <!-- Work Position -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
            <tr>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom;">Iş ýeri, wezipesi:</td>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom;">{{ $order->work_position }}</td>
                @endforeach
            </tr>
        </table>

        <!-- Internet Service -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
            <tr>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; padding: 5px 5px 5px 0; vertical-align: bottom; width: 40%;">
                        Internet-hyzmatyny birikdirmek: {{ $order->internet_service ? 'Hawa' : 'Ýok' }}
                    </td>
                    <td style="font-size: 11pt; padding: 5px 5px 5px 0; vertical-align: bottom; width: 35%;">
                        Internet hyzmatyny ibermeli telefon belgisi:
                    </td>
                    <td style="font-size: 11pt; padding: 5px; vertical-align: bottom; width: 25%;">
                        {{ $order->internet_service ? $order->phone_number : '' }}
                    </td>
                @endforeach
            </tr>
        </table>

        <!-- Email -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
            <tr>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom;">Kart hasaby boýunça hasabatyň ugradylmaly elektron salgysy (E-mail):</td>
                @foreach($orders as $order)
                    <td style="font-size: 11pt; font-weight: bold; padding: 5px; vertical-align: bottom;">{{ $order->email }}</td>
                @endforeach
            </tr>
        </table>

        <!-- Cash Limits -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 15px; margin-bottom: 5px;">
            <tr>
                <td style="font-size: 11pt; padding: 5px 5px 5px 0; vertical-align: bottom; width: 70%;">Nagt pul serişdelerini almalydaky çäklendirme:</td>
                <td style="font-size: 11pt; font-weight: bold; text-align: center; padding: 5px; vertical-align: bottom; width: 15%;">800 TMT</td>
                <td style="font-size: 10pt; font-style: italic; padding: 5px 0 5px 5px; vertical-align: bottom; width: 15%;">(günüň dowamynda)</td>
            </tr>
        </table>

        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
            <tr>
                <td style="font-size: 11pt; padding: 5px 5px 5px 0; vertical-align: bottom; width: 70%;">Nagt däl hasaplaşyklary etmeklige çäklendirme:</td>
                <td style="font-size: 11pt; font-weight: bold; text-align: center; padding: 5px; vertical-align: bottom; width: 15%;">1000 TMT</td>
                <td style="font-size: 10pt; font-style: italic; padding: 5px 0 5px 5px; vertical-align: bottom; width: 15%;">(günüň dowamynda)</td>
            </tr>
        </table>

        <div class="agreement-text">
            Şu Arza - Anketanyň arka tarapyndaky Ylalaşygyň şertleri bilen doly razylaşýaryn we gyşarnyksyz berjaý etmäge söz berýärin.
        </div>

        <!-- Customer Signature -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 25px;">
            <tr>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom; width: 20%;">Müşderiniň goly:</td>
                <td style="vertical-align: bottom; width: 30%;">
                    <div class="signature-line"></div>
                </td>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 20px; vertical-align: bottom; width: 10%;">Sene:</td>
                <td style="vertical-align: bottom; width: 40%;">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width: 25px; border-bottom: 1px solid #000; text-align: center; margin: 0 2px;"></td>
                            <td style="font-size: 11pt; padding: 0 1px;">/</td>
                            <td style="width: 25px; border-bottom: 1px solid #000; text-align: center; margin: 0 2px;"></td>
                            <td style="font-size: 11pt; padding: 0 1px;">/</td>
                            <td style="width: 55px; border-bottom: 1px solid #000; text-align: center; margin: 0 2px;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-header">
        2. Gulluk maglumatlar <span style="font-size: 12pt; font-weight: normal;">(Bank işgäriniň tarapyndan doldurylýar)</span>
    </div>

    <!-- OFFICIAL USE -->
    <div class="official-use">
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
            <tr>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom;">Arzany kabul eden Bank işgäriniň goly:</td>
                <td style="vertical-align: bottom; width: 150px;">
                    <div class="signature-line"></div>
                </td>
                <td style="font-size: 11pt; padding: 5px 0 5px 10px; vertical-align: bottom;">
                    M. Ý. <span style="font-size: 5pt;">Bar bolan ýagdaýynda</span>
                </td>
            </tr>
        </table>

        <div class="agreement-text">
            Şu Arza - Anketanyň arka tarapyndaky Ylalaşygyň şertlerni tassyklap, karty goýbermäge rugsat berýärin.
        </div>

        <!-- Director Signature -->
        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 5px;">
            <tr>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom; width: 25%;">Müdir başlygynyň goly:</td>
                <td style="vertical-align: bottom; width: 25%;">
                    <div class="signature-line"></div>
                </td>
                <td style="vertical-align: bottom; width: 15%; padding: 0 10px;">
                    <div style="border: 1px solid #000; width: 100px; height: 20px;"></div>
                </td>
                <td style="font-size: 11pt; white-space: nowrap; padding: 5px 5px 5px 0; vertical-align: bottom; width: 10%;">Sene:</td>
                <td style="vertical-align: bottom; width: 25%;">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="width: 25px; border-bottom: 1px solid #000; text-align: center; margin: 0 2px;"></td>
                            <td style="font-size: 11pt; padding: 0 1px;">/</td>
                            <td style="width: 25px; border-bottom: 1px solid #000; text-align: center; margin: 0 2px;"></td>
                            <td style="font-size: 11pt; padding: 0 1px;">/</td>
                            <td style="width: 55px; border-bottom: 1px solid #000; text-align: center; margin: 0 2px;"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- FOOTER -->
    <div style="margin-top: 20px; font-size: 10pt; text-align: center; padding-top: 10px;">
        Sorag-jogap gullugy: tel. (+99312) 444345, 445959.<br>
        www.senagatbank.com.tm
    </div>
</div>

</body>
</html>
