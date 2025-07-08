<?php
/**
 * shortcode-public-certificado.php
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function expide_certificado_publico_shortcode( $atts ) {
    $output = '';

    // 1) Formulario con nonce
    $output .= '<form method="post" class="certificado-publico-form">';
    $output .= wp_nonce_field( 'expide_certificado', 'expide_certificado_nonce', true, false );
    $output .= '<label for="cedula">Ingrese su cédula:</label><br>';
    $output .= '<input type="text" name="cedula" id="cedula" required>';
    $output .= '<button type="submit">Descargar certificado</button>';
    $output .= '</form>';

    // 2) Procesar sólo POST con nonce válido
    if (
        'POST' === $_SERVER['REQUEST_METHOD']
        && ! empty( $_POST['cedula'] )
        && isset( $_POST['expide_certificado_nonce'] )
        && wp_verify_nonce( $_POST['expide_certificado_nonce'], 'expide_certificado' )
    ) {
        $cedula     = sanitize_text_field( $_POST['cedula'] );
        $api_key    = defined( 'FLUENT_CRM_API_KEY' )   ? FLUENT_CRM_API_KEY   : '';
        $api_secret = defined( 'FLUENT_CRM_API_SECRET' )? FLUENT_CRM_API_SECRET: '';

        // Llamada REST a FluentCRM por cédula
        $url = site_url( "/wp-json/fluent-crm/v2/subscribers?filters[custom_values.cedula]={$cedula}" );
        $response = wp_remote_get( $url, [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode( "$api_key:$api_secret" ),
                'Accept'        => 'application/json',
            ]
        ] );

        if ( is_wp_error( $response ) ) {
            $output = '<p>' . esc_html__( 'Error al conectar con el CRM. Intenta de nuevo más tarde.', 'gcp-generador-cert' ) . '</p>' . $output;
        } else {
            $data = json_decode( wp_remote_retrieve_body( $response ) );
            if ( empty( $data->records ) ) {
                $output = '<p>' . esc_html__( 'Cédula no registrada. Verifica e inténtalo de nuevo.', 'gcp-generador-cert' ) . '</p>' . $output;
            } else {
                // Tomar datos del primer registro
                $subscriber = $data->records[0];

                // 3) Cargar la plantilla del certificado
                // Opción A: si usas un PHP template dentro de includes/
                ob_start();
                require plugin_dir_path( __FILE__ ) . 'template-certificado.php';
                $html = ob_get_clean();

                // Opción B: si dejas el .html en assets/
                // $html = file_get_contents( plugin_dir_path( __DIR__ ) . 'assets/images/template-certificado.html' );

                // 4) Generar PDF
                try {
                    $mpdf = new \Mpdf\Mpdf([
                        'format'        => 'A4',
                        'margin_top'    => 20,
                        'margin_bottom' => 20,
                        'margin_left'   => 15,
                        'margin_right'  => 15,
                    ]);
                    $mpdf->WriteHTML( $html );
                    $mpdf->Output( "certificado_{$cedula}.pdf", \Mpdf\Output\Destination::DOWNLOAD );
                } catch ( \Mpdf\MpdfException $e ) {
                    $output = '<p>' . esc_html( $e->getMessage() ) . '</p>' . $output;
                }

                exit; // Forzar la descarga
            }
        }
    }

    return $output;
}

// Sólo una llamada a add_shortcode, al final del archivo:
add_shortcode( 'expide_certificado_publico', 'expide_certificado_publico_shortcode' );

add_shortcode( 'expide_certificado_publico', 'expide_certificado_publico_shortcode' );
