<!DOCTYPE html>
<html>

<head>
    <title>Quiz Tool</title>
    <style>
        .tbl {
            /*border:solid 1px #000;*/
            width: 560px;
        }

        .ref {
            text-align: center;
            color: #4E6DA0;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <table width="600" cellspacing="0" cellpadding="0" border="0" align="center">
        <tbody>
            <tr>
                <td height="10" bgcolor="#4E6DA0"></td>
            </tr>
            <tr>
                <td>
                    <table width="600" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                            <tr>
                                <td width="10" bgcolor="#4E6DA0"></td>
                                <td bgcolor="#FFFFFF">
                                    <table width="580" cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td height="10" bgcolor="#4E6DA0"></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="580" cellspacing="0" cellpadding="0"
                                                        border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td height="10"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <table width="580" cellspacing="0"
                                                                        cellpadding="0" border="0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td width="50"></td>
                                                                                <td>
                                                                                    <table width="560"
                                                                                        cellspacing="0" cellpadding="0"
                                                                                        border="0">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td
                                                                                                    style="font-family: Tahoma; font-size: 20px; text-align: center; text-transform: uppercase; font-weight: bold; color: #4E6DA0">
                                                                                                    Welcome to Skill tracking Portal</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td height="15"></td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td
                                                                                                    style="font-family: Tahoma; font-size: 15px; color: #666666">
                                                                                                   Dear {{$details['emp_name']}},
                                                                                                    <br><br>
                                                                                                    Please use this OTP for Login into Skill Tracking Portal
                                                                                                    <br><br>
                                                                                                    <table
                                                                                                        cellspacing="1px;"
                                                                                                        cellpadding="10px;"
                                                                                                        style="width: 560px">
                                                                                                        <tbody>
                                                                                                            <tr>
                        <h4>{{$details['otp']}}</h4>
                                                                                                            </tr>
                                                                                                        </tbody>

                                                                                                    </table>
                                                                                                    <br>
                                                                                                    Thanks,<br><br>
                                                                                                    Colan Infotech Pvt.Ltd
                                                                                                    <br><br>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                                <td width="50"></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td width="10" bgcolor="#4E6DA0"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td height="10" bgcolor="#4E6DA0"></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
