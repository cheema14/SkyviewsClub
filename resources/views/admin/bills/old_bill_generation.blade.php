<html>
   <head>

      <style>
         body{font-family:"Arial",sans-serif;}
      </style>
   </head>
   <body style="width:680px; margin:0 auto; ">
        <p style='margin-top:0in;margin-right:0in;margin-bottom:18.8pt;margin-left:0in;line-height:15.9pt;font-size:19px;text-align:center;'><span style="width:143px;height:126px;">
            <img width="114" src="{{ public_path('img/new_logo.png') }}" alt="image"></span>
        </p>
      <p style='margin-top:0in;margin-right:0in;margin-bottom:10pt;margin-left:0in;line-height:15.9pt;text-align:center;'><strong><span style='font-size:19px;'>PAF SKYVIEW GOLF &amp; SPORTS COMPLEX, LAHORE</span></strong><span><br>&nbsp;</span><span style='font-size:15px;'>MONTHLY BILL</span></p>
      <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:normal;'><span style='font-size:13px;'>Name: <strong><u>{{ $member->name }}</u></strong></span></p>
      <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:normal;'><span style='font-size:13px;'>Membership No. <strong>{{ $member->membership_no }}</strong> bill for the month of <strong><u>{{ date('M', strtotime('-1 month')) }}, {{ date('Y')}}</u></strong></span></p>
      <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:normal;'><span style='font-size:13px;'>Unit/Address: <strong><u>{{ $member->mailing_address }}. Ph- {{ $member->cell_no }}</u></strong>&nbsp;</span></p>
      <table style="margin-top:0.3in; border-collapse:collapse;border:none;">
         <tbody>
            <tr>
               <td style="width: 244.2pt;border: 1pt solid windowtext;padding: 0in 5.4pt;vertical-align: top;">
                  <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:normal;text-align:center;'><strong><span style='font-size:16px;'>DESCRIPTION</span></strong></p>
               </td>
               <td style="width: 232.8pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0in 5.4pt;vertical-align: top;">
                  <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:normal;text-align:center;'><strong><span style='font-size:16px;'>AMOUNT</span></strong></p>
               </td>
            </tr>
            <tr>
               <td style="width: 244.2pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;vertical-align: top;">
                  <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:  normal;'><span style='font-size:15px;'>Balance BF/CR</span></p>
               </td>
               <td style="width: 232.8pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0in 5.4pt;vertical-align: top;">
                  <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:normal;font-size:19px;text-align:center;'><span>{{ number_format($member?->arrears)}}</span></p>
               </td>
            </tr>
            <tr>
               <td style="width: 244.2pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;vertical-align: top;">
                  <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:  normal;'><span style='font-size:15px;'>Monthly Subscription</span></p>
               </td>
               <td style="width: 232.8pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0in 5.4pt;vertical-align: top;">
                  <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:normal;font-size:19px;text-align:center;'><span>{{ number_format($member->membership_type?->monthly_fee) }}</span></p>
               </td>
            </tr>
            <tr>
               <td style="width: 244.2pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;vertical-align: top;">
                  <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:  normal;'><span style='font-size:15px;'>Sports Bill</span></p>
               </td>
               <td style="width: 232.8pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0in 5.4pt;vertical-align: top;">
                  <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:normal;font-size:19px;text-align:center;'><span>{{ $sportsBill }}</span></p>
               </td>
            </tr>
            
            <tr>
               <td style="width: 244.2pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;vertical-align: top;">
                  <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:  normal;font-size:19px;'><span style='font-size:15px;'>Restaurant</span></p>
               </td>
               <td style="width: 232.8pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0in 5.4pt;vertical-align: top;">
                  <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:normal;font-size:19px;text-align:center;'><span>{{ number_format($bill) }}</span></p>
               </td>
            </tr>
            
            <tr>
               <td style="width: 244.2pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;vertical-align: top;">
                  <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:  normal;'><strong><span style='font-size:15px;'>Total</span></strong></p>
               </td>
               <td style="width: 232.8pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0in 5.4pt;vertical-align: top;">
                  {{-- <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:normal;
                  text-align:center;'><span>{{ number_format($member?->membership_type->monthly_fee + $member->arrears + $bill + $sportsBill) }}</span></p> --}}
                  <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:normal;
                  text-align:center;'>
                     <span>   
                        {{ number_format($bill->total) }}
                     </span>
                  </p>
                  
               </td>
            </tr>
            <tr>
               <td style="width: 244.2pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;vertical-align: top;">
                  <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:  normal;'><strong><span style='font-size:15px;'>Credit (This Month)</span></strong></p>
               </td>
               <td style="width: 232.8pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0in 5.4pt;vertical-align: top;">
                  <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:normal;font-size:19px;text-align:center;'><span>{{ number_format($currentMonthCredit?->received_amount) }}</span></p>
               </td>
            </tr>
            <tr>
               <td style="width: 244.2pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0in 5.4pt;vertical-align: top;">
                  <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:  normal;'><strong><span style='font-size:15px;'>Cr / Net Balance Payable</span></strong></p>
               </td>
               <td style="width: 232.8pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0in 5.4pt;vertical-align: top;">
                  <p style='margin-top:0in;margin-right:0in;margin-bottom:.0001pt;margin-left:0in;line-height:normal;text-align:center;'><span>{{ $member->latestBill?->net_balance_payable +  $payment_receipts_bill_types?->received_amount }}</span></p>
               </td>
            </tr>
         </tbody>
      </table>
      <p style='margin-top:0.3in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:normal;'><span style='font-size:13px;'>Received with thanks Cheque No._____________________________ Rs. _______________________________</span></p>
      <p style='margin-top:0in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:normal;'><span style='font-size:13px;'>In payment for above bill ___________________________________________________________</span></p>
      <p style='margin-top:0.3in;margin-right:0in;margin-bottom:8.0pt;margin-left:0in;line-height:112%;text-align:right;'><span style='font-size:13px;line-height:112%;'>Honorary Secretary</span></p>
      <p style='margin-top:0in;margin-right:0in;margin-bottom:4.0pt;margin-left:0in;'><span style='font-size:13px;line-height:112%;'>Note:</span></p>
      <ol style="list-style-type: decimal;">
         <li style="margin-bottom:8.0pt"><span style='line-height:150%;font-size:11.0pt;'>For Online transaction JS Bank Account No 0001286133 (IBAN No PK72JSBL9561000001286133), Receipt /screen shot may be Shared with PSGCC Accounts Office through Whatsapp on Cell No +92 323-9420064.</span></li>
         <li style="margin-bottom:8.0pt"><span style='line-height:150%;font-size:11.0pt;'>PGA capitation charges are applicable to all.</span></li>
         <li style="margin-bottom:8.0pt"><span style='line-height:150%;font-size:11.0pt;'>Delayed payments are not encouraged; as it may lead to compromise on services being provided to our esteemed members, to discourage this trend and for the benefit of larger number community,as per Club policy following will be implemented:</span>
             <ol style="list-style-type: lower-alpha; margin-top:0;">
                 <li><span style='line-height:150%;font-size:11.0pt;'>Bills are to be cleared by 15th of each month.</span></li>
                 <li><span style='line-height:150%;font-size:11.0pt;'>Upon non-payment of bills up to one month; membership will become inactive.</span></li>
                 <li><span style='line-height:150%;font-size:11.0pt;'>For outstanding dues up to three months, membership will be suspended and would be activated upon payment of restoration charges of Rs 100,000/-.</span></li>
             </ol>
         </li>
         {{-- <li><span style='line-height:150%;font-size:11.0pt;'>As per Club Policy, if the bill is not cleared by 31<sup>st</sup> Dec, 2023, your membership will be temporarily suspended followed by process for cancellation.</span></li> --}}
     </ol> 
   </body>
</html>
