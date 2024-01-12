
<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title>Malamal | Home</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="">
    <meta property="og:type" content="">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Place favicon.ico in the root directory -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&display=swap" rel="stylesheet">
    <!-- CSS only -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
        crossorigin="anonymous">


    <meta name="theme-color" content="#fafafa">
</head>

<body>
<style type="text/css">
    .report-sec{
        width: 1000px;
        padding: 20px;
        margin: 20px;
        margin: 0px auto;
        background: #fff;
    }
    .quotation-box{
        border: 1px dotted; #000;
        padding: 20px;
        margin-top: 30px;
    }

    .ref-box h4{
        font-size: 18px;
        margin: 0px;
    }
    .ref-box h5{
        font-size: 16px;
    }

    .ref-box {
        margin-bottom: 25px;
    }

    .to-box p{
        margin: 0px;
        font-size: 15px;
    }
    .to-box h5{
        margin: 0px;
        font-size: 17px;
        font-weight: bold;
    }


    .quotation-creator h3{
        margin-bottom: 30px;
    }

    .quotation-creator p{
        margin: 0px;
        font-size: 15px;
    }


    .report-subject{
        margin-top: 20px;
    }

    .report-subject h5{
        text-decoration: underline;
        font-size: 17px;
        font-weight: bold;
        margin-bottom: 20px;

    }

    .quotation-creator h5{
        font-size: 17px;
        font-weight: bold;
    }

    .best-regards h5{
        font-size: 17px;
        font-weight: bold;
        margin-bottom: 80px;
    }

    .note-book h5{
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 40px;
        text-decoration: underline;
    }

    .regard-name h5{
        font-size: 17px;
        font-weight: bold;
        margin: 0px;
    }
    .regard-name p{
        margin: 0px;
    }

    .report-logo img{
        width: 300px;
        margin-left: 40px;
        margin-bottom: 15px;
    }

    .report-note{
        list-style: none;
        margin: 0px;
        padding: 0px;
    }
    .report-note li span{
        padding: 8px;
        border-right: 1px solid #000;
        width: 37px;
        display: inline-block;
        text-align: center;
        margin-bottom: 1px;
    }
    .pad-address{
        text-align: right;
    }
    .pad-address img{
        width: 250px;
    }
    .pad-address p{
        margin: 0px;
        font-size: 12px;
    }
    .remarks h5{
        margin: 0px;
        font-size: 18px;
        font-weight: bold;
    }
</style>
<section class="report-sec">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="quotation-box">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="report-logo">
                                <img src="{!! asset('public/assets/back-end/images/reportlogo.png') !!}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="ref-box">
                                <h4>Ref: REF/{!! $quotation->reference_no !!}</h4>
                                <h5>Date: {!! $quotation->created_at !!}</h5>
                            </div>
                            <div class="to-box">
                                <p>To</p>
                                <h5><u>{!! $quotation->customer->phone !!}<br>{!! $quotation->customer->name !!}</u></h5>
                                <p>Delivery Location: inside in Dhaka</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="quotation-creator">
                                <h3>QUOTATION</h3>
                                <h5>Attn: Mohammad Omar Faruq</h5>
                                <p>Executive-Procurement</p>
                                <p>Contact: +88001713359800</p>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="report-subject">
                                <h5>Subject: Price Quotation for "Egg Crates with Print"</h5>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="report-table">
                                <table class="table table-bordered border-dark" style="border: 2px solid #000;">
                                    <thead>
                                    <tr style="background: #f2f2f2;">
                                        <th scope="col" style="text-align: center;">No</th>
                                        <th scope="col" style="text-align: center;">Item Name</th>
                                        <th scope="col" style="text-align: center;">Spec</th>
                                        <th scope="col" style="text-align: center;">Unit</th>
                                        <th scope="col" style="text-align: center;">QTY</th>
                                        <th scope="col" style="text-align: center;">Unit Price</th>
                                        <th scope="col" style="text-align: center;">VAT</th>
                                        <th scope="col" style="text-align: center;">Unit Vat Amount</th>
                                        <th scope="col" style="text-align: center;">Unit Price (with VAT)</th>
                                        <th scope="col" style="text-align: center;">Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($quotation->productQuotations))
                                        @foreach($quotation->productQuotations as $key=>$pro)
                                    <tr class="text-center">
                                        <td>{!! $key+1 !!}</td>
                                        <td>{!! $pro->product->name ?? ' ' !!}</td>
                                        <td>
                                            {!! $pro->product->description ?? ' ' !!}
                                        </td>
                                        <td>Pcs</td>
                                        <td>{!! $pro->net_unit_price !!}</td>
                                        <td>24.50ট</td>
                                        <td>0.0%</td>
                                        <td>0.00ট </td>
                                        <td>{!! $pro->net_unit_price !!}ট </td>
                                        <td>{!! $pro->total !!}ট </td>
                                    </tr>
                                        @endforeach
                                    @endif

                                    <tr>
                                        <td colspan="10" class="remarks">
                                            <h5>NOTE & REMARKS: </h5>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" style="padding: 0px;">
                                            <ul class="report-note">
                                                <li><span>1</span> The Quoted prices are inclusive of VAT & AIT, Shipping Cost.</li>
                                                <li><span>2</span> Quotation is valid for next 7 days.</li>
                                                <li><span>3</span> <strong>Delivery Timeline:</strong> From Ready Stock.</li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td colspan="9">
                                            <strong>Payment Terms: </strong>BEFTN made in favor of "Malamal.xyz Ltd".
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="note-book">
                                <h5>N.B. Under SRO 234-AIN/2019/70-Mushak (Service Code 99.60), Online (E-Commerce).Businesses are Subjected to charge 5% VAT with their Invoices.</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="best-regards">
                                <h5>Best Regards</h5>
                                <div class="regard-name">
                                    <h5>Md. Tasnim Hossain Fahim</h5>
                                    <p>team Leader, Sales & Business Development</p>
                                    <p>Contact: 0197525821</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="note-book">

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="pad-address">

                                <img src="{!! asset('public/assets/back-end/images/reportlogo.png') !!}">
                                <p><small>Malamal.xyz is Bangladesh’s leading B2B and B2C portal for</small></p>
                                <p><strong>Head Office:</strong> Holding No: 100-103, 2nd Floor, Nawabpur Road, Dhaka - 1100 <span>Cell: 019721527421, 01248752357</span></p>
                                <p><strong>Sales Center:</strong> Level 11 & 12, Medona Tower, 28, Mohakhali C/A, Dhaka-1212</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- JavaScript Bundle with Popper -->

</body>
</html>