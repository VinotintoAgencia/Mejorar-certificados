
    // HTML y CSS del certificado (basado en tu archivo certificadohseq.html)
    $html = <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Certificado - {$nombre_completo}</title>
  <style>
    /* Reset y tipografía */
    * { margin:0; padding:0; box-sizing:border-box; }
    body {
      font-family: 'DejaVu Sans', sans-serif;
      color: #333;
      background: #fff;
      line-height:1.5;
      font-size:11pt;
    }
    .certificate {
      padding:20mm;
      position:relative;
    }
    /* Marca de agua muy sutil */
    .certificate::before {
      content: 'HSEQ del Golfo';
      position:absolute;
      top:50%; left:50%;
      transform:translate(-50%,-50%) rotate(-30deg);
      font-size:100pt;
      color:#4f81ba;
      opacity:0.03;
      z-index:0;
    }
    /* Encabezado con línea de acento */
    .header {
      width:100%; margin-bottom:15px;
      border-bottom:3px solid #4f81ba;
    }
    .header td {
      vertical-align:middle;
    }
   .logo img {
  width: 80px !important;
  height: auto;
    }
    .title {
      text-align:center;
      font-weight:700;
      color:#4f81ba;
      font-size:18pt;
      font-family: 'DejaVu Sans', sans-serif;
      padding-left:10px;
    }
    .title small {
      display:block;
      font-size:8pt;
      color:#555;
      margin-top:4px;
      font-weight:400;
    }
    /* Secciones principales */
    .section {
      text-align:center;
      margin:20px 0;
    }
    .section .label {
      font-weight:600;
      font-size:10pt;
      margin-bottom:4px;
    }
    .section .value {
      font-size:16pt;
      font-weight:700;
      margin-top:2px;
    }
    /* Tabla de detalles refinada */
    .details {
      width:100%;
      border-collapse:collapse;
      margin:20px 0;
      font-size:9pt;
    }
    .details th, .details td {
      padding:8px 6px;
      text-align:left;
      border-bottom:1px solid #e0e0e0;
    }
    .details th {
      background:#4f81ba;
      color:#fff;
      font-weight:600;
    }
    /* Firmas */
    .signatures {
      width:100%;
      margin-top:30px;
      font-size:9pt;
    }
    .signatures td {
      width:50%;
      text-align:center;
      vertical-align:top;
      padding:0 10px;
    }
    .sign-line {
      border-top:1px solid #333;
      width:70%;
      margin:0 auto 6px;
    }
    /* Pie de página minimalista */
    .footer {
      text-align:center;
      font-size:7pt;
      color:#777;
      border-top:1px solid #e0e0e0;
      padding-top:8px;
    }
    .footer a {
      color:#4f81ba;
      text-decoration:none;
      font-weight:600;
    }
  </style>
</head>
<body>
  <div class="certificate">
    <table class="header">
      <tr>
        <td class="logo">
          <img src="{$logo_url}" alt="Logo HSEQ" style="width:100px; height:auto;" >
        </td>
        <td class="title">
          Certificado de formación y entrenamiento<br>
          <small>MINTRABAJO N° RADICADO 08SE2018220000000030200</small>
        </td>
      </tr>
    </table>

    <div class="section">
      <div class="label">Certifica que:</div>
      <div class="value">{$nombre_completo}</div>
    </div>

    <div class="section">
      <div class="label">Cursó y aprobó la formación y entrenamiento en:</div>
      <div class="value">"{$nombre_curso}"</div>
    </div>

    <table class="details">
      <tr><th>Intensidad</th><td>{$intensidad_horaria} horas, bajo la resolución {$resolucion_mintrabajo}</td></tr>
      <tr><th>Realizado en</th><td>{$ciudad_expedicion} entre el {$fecha_inicio_curso} y el {$fecha_realizado}</td></tr>
      <tr><th>Expedido en</th><td>{$ciudad_expedicion}, el {$fecha_expedicion}</td></tr>
      <tr><th>Validación</th><td>NCI - HSEQ - {$codigo_validacion}</td></tr>
      <tr><th>NIT Empresa</th><td>{$nit_empresa}</td></tr>
      <tr><th>Representante Legal</th><td>{$representante_legal_empleadora}</td></tr>
      <tr><th>ARL</th><td>{$arl}</td></tr>
    </table>

    <table class="signatures">
      <tr>
        <td>
          <div class="sign-line"></div>
          <p>{$nombre_entrenador}<br>Entrenador SST<br>Licencia: {$licencia_sst_entrenador}</p>
        </td>
        <td>
          <div class="sign-line"></div>
          <p>{$representante_legal_certificadora}<br>Representante Legal</p>
        </td>
      </tr>
    </table>

    <div class="footer">
      <p>{$licencia_sst_hseq}</p>
      <p>Verifíquese llamando al <strong>{$telefonos_verificacion}</strong></p>
      <p>Autenticidad en <a href="{$url_verificacion_web}" target="_blank">{$web_verificacion_display}</a></p>
    </div>
  </div>
</body>
</html>
HTML;
    return $html;
}