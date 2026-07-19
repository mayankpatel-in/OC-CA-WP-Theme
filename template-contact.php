<?php
/**
 * Template Name: Contact Us
 *
 * Contact page with hero, contact detail cards (pulled from the
 * same Customizer settings as the footer), an enquiry form, and
 * optional extra content from the page editor (e.g. a map embed).
 *
 * @package OC_CA_Theme
 */

get_header();

while ( have_posts() ) :
    the_post();

    // Contact info (from Customizer, same as footer)
    $address   = get_theme_mod( 'footer_address',   'G 20 Ashoka Mall, Bund Garden Road, Pune - 411001' );
    $phone     = get_theme_mod( 'footer_phone',     '+91 80555 66789' );
    $email     = get_theme_mod( 'footer_email',     'office@anbca.com' );
    $wa_num    = get_theme_mod( 'footer_wa_number', '918055566789' );
    $phone_raw = preg_replace( '/\D/', '', $phone );
    $wa_raw    = preg_replace( '/\D/', '', $wa_num );
?>

<!-- SUBPAGE HERO BANNER -->
<section class="subpage-hero">
    <div class="container">
        <?php oc_ca_breadcrumbs(); ?>
        <div class="subpage-hero-title">
            <h1><?php the_title(); ?></h1>
            <p class="lead">Speak with a senior Chartered Accountant — call, WhatsApp, email, or send us a message and we'll get back to you within one business day.</p>
        </div>
    </div>
</section>

<!-- CONTACT MAIN -->
<main class="subpage-main">
    <div class="container">

        <div class="contact-grid">

            <!-- LEFT: CONTACT DETAIL CARDS -->
            <div class="contact-info-column">

                <div class="sidebar-card contact-info-card">
                    <div class="contact-info-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <div>
                        <h4>Office Address</h4>
                        <p><?php echo esc_html( $address ); ?></p>
                    </div>
                </div>

                <div class="sidebar-card contact-info-card">
                    <div class="contact-info-icon"><i class="fa-solid fa-phone"></i></div>
                    <div>
                        <h4>Call Us</h4>
                        <p><a href="tel:<?php echo esc_attr( $phone_raw ); ?>"><?php echo esc_html( $phone ); ?></a></p>
                    </div>
                </div>

                <div class="sidebar-card contact-info-card">
                    <div class="contact-info-icon"><i class="fa-brands fa-whatsapp"></i></div>
                    <div>
                        <h4>WhatsApp</h4>
                        <p><a href="https://wa.me/<?php echo esc_attr( $wa_raw ); ?>" target="_blank" rel="noopener noreferrer">Chat with us instantly</a></p>
                    </div>
                </div>

                <div class="sidebar-card contact-info-card">
                    <div class="contact-info-icon"><i class="fa-solid fa-envelope"></i></div>
                    <div>
                        <h4>Email</h4>
                        <p><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
                    </div>
                </div>

                <div class="sidebar-card contact-info-card">
                    <div class="contact-info-icon"><i class="fa-solid fa-clock"></i></div>
                    <div>
                        <h4>Working Hours</h4>
                        <p>Mon – Sat: 10:00 AM – 7:00 PM</p>
                    </div>
                </div>

            </div>

            <!-- RIGHT: ENQUIRY FORM -->
            <div class="content-column contact-form-column">
                <h2>Send Us a Message</h2>
                <p>Fill in the form below and our expert team will reach out to you shortly.</p>

                <form id="contactPageForm" class="interactive-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contactName"><i class="fa-solid fa-user"></i> Full Name</label>
                            <input type="text" id="contactName" name="name" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group">
                            <label for="contactPhone"><i class="fa-solid fa-phone"></i> Phone Number</label>
                            <input type="tel" id="contactPhone" name="phone" placeholder="Mobile number" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contactEmail"><i class="fa-solid fa-envelope"></i> Email Address</label>
                        <input type="email" id="contactEmail" name="email" placeholder="Work email" required>
                    </div>
                    <div class="form-group">
                        <label for="contactMessage"><i class="fa-solid fa-message"></i> Your Message</label>
                        <textarea id="contactMessage" name="message" rows="5" placeholder="Tell us briefly what you need help with" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Send Message</button>
                </form>

                <div class="form-success" id="contactPageSuccess" style="display:none; text-align:center; padding:30px 0;">
                    <i class="fa-solid fa-circle-check" style="font-size:2.5rem;color:var(--success);margin-bottom:0.7rem;display:block;"></i>
                    <h4>Message Sent!</h4>
                    <p>Thank you for reaching out. Our team will get back to you shortly.</p>
                </div>
            </div>

        </div>

        <?php if ( trim( get_the_content() ) !== '' ) : ?>
        <!-- OPTIONAL EXTRA CONTENT (e.g. map embed, directions) -->
        <div class="content-column contact-extra-content">
            <div class="blog-content page-content">
                <?php the_content(); ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</main>

<?php
endwhile;

get_footer();
