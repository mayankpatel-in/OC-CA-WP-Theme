<?php
/**
 * OC CA Theme - Homepage Sections
 *
 * All homepage sections (hero, stats, services grid, slideshow,
 * why choose us, team, callback, accordions, testimonials, FAQs,
 * partners marquee). Shared by front-page.php and the
 * "Home Page" page template (template-home.php).
 *
 * @package OC_CA_Theme
 */
?>

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="hero-bg-slider">
        <div class="hero-slide active" style="background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 30%, rgba(49, 144, 231, 0.4)), url('https://www.anbca.com/wp-content/uploads/2019/01/LeaveTheRestOnUs.jpg') center/cover no-repeat;"></div>
    </div>

    <div class="container hero-content-grid">
        <div class="hero-text-box">
            <span class="badge">A N Bhutada &amp; Co | Chartered Accountants</span>
            <h1>Are you searching for a One-Stop Registrations, Accounting, Tax &amp; Audit Firm?</h1>
            <p>We provide comprehensive CA &amp; CS services across PAN India — Company Registration, GST, Tax Filing, Auditing, Payroll, and Accounting — all under one roof. Let us handle your compliance so you can focus on growing your business.</p>
            <div class="hero-actions">
                <a href="#services" class="btn btn-accent"><i class="fa-solid fa-circle-arrow-down"></i> Explore Services</a>
                <button class="btn btn-outline" id="heroCallbackBtn"><i class="fa-solid fa-phone-volume"></i> Setup Free Advise Call</button>
            </div>

            <!-- Trust indicators -->
            <div class="hero-trust">
                <div class="hero-trust-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>Services Across PAN India</span>
                </div>
                <div class="hero-trust-item">
                    <i class="fa-solid fa-certificate"></i>
                    <span>Zoho Certified Partner</span>
                </div>
                <div class="hero-trust-item">
                    <i class="fa-brands fa-google"></i>
                    <span>4.9&nbsp;<i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star" aria-hidden="true"></i><i class="fa-solid fa-star-half-stroke" aria-hidden="true"></i> Google Rating</span>
                </div>
            </div>
        </div>

        <!-- Book Free Consultation Form -->
        <div class="hero-form-box">
            <div class="form-wrapper">
                <h3>Book Free Consultation</h3>
                <p>Share your details and our senior CA will call you within 15 minutes.</p>
                <form id="heroQuoteForm" class="interactive-form">
                    <div class="form-group">
                        <label for="quoteName"><i class="fa-solid fa-user"></i> Full Name</label>
                        <input type="text" id="quoteName" name="name" placeholder="Enter your name" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="quotePhone"><i class="fa-solid fa-phone"></i> Phone Number</label>
                            <input type="tel" id="quotePhone" name="phone" placeholder="Mobile number" required>
                        </div>
                        <div class="form-group">
                            <label for="quoteEmail"><i class="fa-solid fa-envelope"></i> Email Address</label>
                            <input type="email" id="quoteEmail" name="email" placeholder="Work email" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-accent btn-full">Book Consultation <i class="fa-solid fa-arrow-right-long"></i></button>
                </form>
                <div class="form-success" id="heroFormSuccess" style="display:none; text-align:center;">
                    <i class="fa-solid fa-circle-check"></i>
                    <h4>Thank You!</h4>
                    <p>Our expert team will contact you within 15 minutes.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- KEY STATS COUNTER RIBBON -->
<section class="stats-section">
    <div class="container stats-grid" id="statsContainer">
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div>
            <div class="stat-number-box">
                <span class="stat-number" data-target="1000">0</span><span class="stat-plus">+</span>
            </div>
            <p class="stat-label">Happy Clients</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-map-location-dot"></i></div>
            <div class="stat-number-box">
                <span class="stat-number" data-target="10">0</span><span class="stat-plus">+</span>
            </div>
            <p class="stat-label">Cities Served</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-earth-americas"></i></div>
            <div class="stat-number-box">
                <span class="stat-number" data-target="5">0</span><span class="stat-plus">+</span>
            </div>
            <p class="stat-label">Countries Served</p>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fa-solid fa-award"></i></div>
            <div class="stat-number-box">
                <span class="stat-number" data-target="15">0</span><span class="stat-plus">+</span>
            </div>
            <p class="stat-label">Years of Excellence</p>
        </div>
    </div>
</section>

<!-- CORE SERVICES GRID -->
<section class="services-section" id="services">
    <div class="container">
        <div class="section-header">
            <span class="sub-title">Expert Solutions</span>
            <h2>Our Core Professional Services</h2>
            <div class="heading-line"></div>
            <p>Top online CA and CS services tailored to fuel startup growth and maintain enterprise financial compliance.</p>
        </div>

        <div class="services-grid">
            <?php
            $svc_defaults = array(
                1 => array( 'icon' => 'fa-file-invoice',           'title' => 'GST Registration',    'desc' => 'Get your GST number in 3 days with complete ARN registration and 1-month comprehensive filing support.', 'price' => 2800 ),
                2 => array( 'icon' => 'fa-building-shield',        'title' => 'Company Registration', 'desc' => 'Incorporate your Private Limited or LLP with AOA, MOA, COI, DSC, PAN &amp; TAN secured in just 15 days.',  'price' => 9800 ),
                3 => array( 'icon' => 'fa-users-gear',             'title' => 'Payroll Processing',   'desc' => 'Accurate monthly payroll processing with full compliance management for PF, ESIC, PT, and TDS deductions.', 'price' => 1499 ),
                4 => array( 'icon' => 'fa-user-tie',               'title' => 'Proprietorship',       'desc' => 'Start a sole proprietorship business managed, owned, and controlled by a single individual securely.',    'price' => 1499 ),
                5 => array( 'icon' => 'fa-receipt',                'title' => 'GST Filing',           'desc' => 'Accurate monthly or quarterly GST return files prepared by certified experts to keep your compliance clean.', 'price' => 999 ),
                6 => array( 'icon' => 'fa-magnifying-glass-chart', 'title' => 'Tax Audit',            'desc' => 'Deep review and evaluation of your business books and returns by Chartered Accountants to ensure accuracy.', 'price' => 15000 ),
                7 => array( 'icon' => 'fa-hand-holding-dollar',    'title' => 'Income Tax Filing',    'desc' => 'File online returns with customized advisory inputs from tax specialists to guarantee maximum tax savings.', 'price' => 1499 ),
                8 => array( 'icon' => 'fa-cloud-arrow-up',         'title' => 'Cloud Accounting',     'desc' => 'Modern books setup using Zoho, QuickBooks, and Wave. Ideal for small, medium, and fast-growing companies.', 'price' => 3800 ),
            );

            for ( $n = 1; $n <= 8; $n++ ) :
                $d     = $svc_defaults[ $n ];
                $pfx   = 'home_service_' . $n . '_';
                $icon  = sanitize_html_class( get_theme_mod( $pfx . 'icon',  $d['icon'] ) );
                $title = esc_html( get_theme_mod( $pfx . 'title', $d['title'] ) );
                $desc  = esc_html( get_theme_mod( $pfx . 'desc',  $d['desc'] ) );
                $price = absint( get_theme_mod( $pfx . 'price', $d['price'] ) );
                $pid   = absint( get_theme_mod( $pfx . 'page',  0 ) );
                $link  = ( $pid > 0 ) ? esc_url( get_permalink( $pid ) ) : '#';
            ?>
            <div class="service-card">
                <div class="service-icon"><i class="fa-solid <?php echo esc_attr( $icon ); ?>"></i></div>
                <h3><?php echo $title; ?></h3>
                <p><?php echo $desc; ?></p>
                <div class="service-footer">
                    <?php if ( $price > 0 ) : ?>
                    <div class="service-price">
                        Starting from<strong>&#8377;<?php echo number_format( $price ); ?></strong>
                    </div>
                    <?php endif; ?>
                    <a href="<?php echo $link; ?>" class="btn btn-outline btn-sm service-more-btn">
                        More <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- DETAILED SERVICE SLIDESHOW SECTION -->
<section class="slides-section">
    <div class="container slider-box">
        <div class="slider-tabs">
            <button class="slider-tab active" data-slide="0">Company Registration</button>
            <button class="slider-tab" data-slide="1">GST Registration</button>
            <button class="slider-tab" data-slide="2">Auditing Services</button>
        </div>

        <div class="slider-content-wrapper">
            <!-- Slide 1 -->
            <div class="slider-item active" id="slide-0">
                <div class="slider-grid">
                    <div class="slider-text">
                        <h3>Private Limited Company Registration</h3>
                        <p>Private Limited Company Registration is the most preferred form of business entity for startups and growing entrepreneurs in India. It limits individual liability, offers high credibility with financial institutions, and makes raising venture funding smooth.</p>
                        <ul class="checkmark-list">
                            <li><i class="fa-solid fa-check"></i> Limited liability protection for shareholders</li>
                            <li><i class="fa-solid fa-check"></i> High legal credibility &amp; status</li>
                            <li><i class="fa-solid fa-check"></i> Easier access to bank loans and VC funding</li>
                            <li><i class="fa-solid fa-check"></i> Smooth digital shares transfer</li>
                        </ul>
                        <button class="btn btn-primary quick-quote-service" data-service="Company Registration">Get a Custom Quote</button>
                    </div>
                    <div class="slider-image" style="background: url('https://www.anbca.com/wp-content/uploads/2023/02/company.png') center/cover no-repeat; border-radius: 20px;"></div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="slider-item" id="slide-1">
                <div class="slider-grid">
                    <div class="slider-text">
                        <h3>GST Registration &amp; Compliances</h3>
                        <p>GST is a value-added tax levied at all transactions in the business supply chain. Proper registration and timely filing are key to claiming Input Tax Credits (ITC) and maintaining legal compliance across state boundaries.</p>
                        <ul class="checkmark-list">
                            <li><i class="fa-solid fa-check"></i> Seamless inter-state trade transactions</li>
                            <li><i class="fa-solid fa-check"></i> Elimination of cascading tax effects</li>
                            <li><i class="fa-solid fa-check"></i> Legally verified Input Tax Credit claims</li>
                            <li><i class="fa-solid fa-check"></i> Standardized monthly return compliance</li>
                        </ul>
                        <button class="btn btn-primary quick-quote-service" data-service="GST Registration">Get a Custom Quote</button>
                    </div>
                    <div class="slider-image" style="background: url('https://www.anbca.com/wp-content/uploads/slider/cache/8d1e5abd24d0325a8eab99cb151b3f68/register-company-cyprus.jpg') center/cover no-repeat; border-radius: 20px;"></div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="slider-item" id="slide-2">
                <div class="slider-grid">
                    <div class="slider-text">
                        <h3>Statutory &amp; Internal Auditing Services</h3>
                        <p>Statutory audits are compulsory audits required under business laws to inspect the true state of financial records. Our audit team checks compliance, validates books, and verifies standard ledger entries to deliver stakeholder transparency.</p>
                        <ul class="checkmark-list">
                            <li><i class="fa-solid fa-check"></i> Legal compliance under the Companies Act</li>
                            <li><i class="fa-solid fa-check"></i> Detection of accounting loopholes and frauds</li>
                            <li><i class="fa-solid fa-check"></i> Enhanced financial report credibility</li>
                            <li><i class="fa-solid fa-check"></i> Internal financial control auditing</li>
                        </ul>
                        <button class="btn btn-primary quick-quote-service" data-service="Tax Audit">Get a Custom Quote</button>
                    </div>
                    <div class="slider-image" style="background: url('https://www.anbca.com/wp-content/uploads/slider/cache/d84ff7241801e8012efa1534316f221f/auditing2.jpg') center/cover no-repeat; border-radius: 20px;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- WHY CHOOSE US SECTION -->
<section class="why-choose-section">
    <div class="container">
        <div class="section-header align-center">
            <span class="sub-title">Why Choose Us</span>
            <h2>Partnering in Your Financial Growth</h2>
            <div class="heading-line"></div>
            <p>We combine deep domain expertise with high professional values to secure client interests.</p>
        </div>

        <div class="features-grid">
            <div class="feature-box">
                <div class="feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <h3>Client Confidentiality</h3>
                <p>All sensitive information and data related to our clients is held under non-disclosure. We safeguard your corporate financial files with extreme priority.</p>
            </div>
            <div class="feature-box">
                <div class="feature-icon"><i class="fa-solid fa-headset"></i></div>
                <h3>Customer Support</h3>
                <p>We maintain highly interactive relations with clients. Our response SLA guarantees resolving queries through a time-bound client ticket support system.</p>
            </div>
            <div class="feature-box">
                <div class="feature-icon"><i class="fa-solid fa-hourglass-half"></i></div>
                <h3>Time &amp; Cost Effectiveness</h3>
                <p>Quality consulting doesn't have to be prohibitively expensive. We deliver professional reports and filings within tight deadlines at industry-optimal rates.</p>
            </div>
            <div class="feature-box">
                <div class="feature-icon"><i class="fa-solid fa-briefcase"></i></div>
                <h3>50+ Services Offered</h3>
                <p>We are a true one-stop compliance destination. From company formation to final audits, our dedicated team manages all corporate regulations under one roof.</p>
            </div>
        </div>
    </div>
</section>

<!-- TEAM SECTION -->
<section class="team-section">
    <div class="container">
        <div class="section-header align-center">
            <span class="sub-title">Our Experts</span>
            <h2>Meet Our Team</h2>
            <div class="heading-line"></div>
            <p>Qualified professionals with deep domain expertise across taxation, audit, corporate law, and financial compliance.</p>
        </div>

        <?php
        $img_base = get_template_directory_uri() . '/assets/img/team/';
        $team     = array();
        for ( $n = 1; $n <= 8; $n++ ) {
            $pfx  = 'home_team_' . $n . '_';
            $name = trim( get_theme_mod( $pfx . 'name', '' ) );
            if ( '' === $name ) continue;
            $img_val = get_theme_mod( $pfx . 'img', '' );
            $img_url = ( $img_val && ( 0 === strpos( $img_val, 'http' ) || 0 === strpos( $img_val, '/' ) ) )
                       ? esc_url( $img_val )
                       : ( $img_val ? esc_url( $img_base . $img_val ) : '' );
            $skills_raw = get_theme_mod( $pfx . 'skills', '' );
            $skills     = array_values( array_filter( array_map( 'trim', explode( "\n", $skills_raw ) ) ) );
            $team[] = array(
                'id'     => 'member-' . $n,
                'name'   => $name,
                'role'   => get_theme_mod( $pfx . 'role', '' ),
                'img'    => $img_url,
                'bio'    => get_theme_mod( $pfx . 'bio', '' ),
                'skills' => $skills,
            );
        }
        ?>

        <!-- Tab buttons -->
        <div class="team-tabs-wrapper">
            <div class="team-tabs" role="tablist">
                <?php foreach ( $team as $i => $m ) : ?>
                <button class="team-tab<?php echo $i === 0 ? ' active' : ''; ?>"
                        role="tab"
                        aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                        aria-controls="member-<?php echo esc_attr( $m['id'] ); ?>"
                        data-member="<?php echo esc_attr( $m['id'] ); ?>">
                    <?php echo esc_html( $m['name'] ); ?>
                </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Tab panels -->
        <div class="team-panels">
            <?php foreach ( $team as $i => $m ) : ?>
            <div class="team-panel<?php echo $i === 0 ? ' active' : ''; ?>"
                 id="member-<?php echo esc_attr( $m['id'] ); ?>"
                 role="tabpanel">
                <div class="team-panel-grid">

                    <!-- Photo + name block -->
                    <div class="team-photo-col">
                        <div class="team-photo">
                            <?php if ( $m['img'] ) : ?>
                                <img src="<?php echo esc_url( $img_base . $m['img'] ); ?>"
                                     alt="<?php echo esc_attr( $m['name'] ); ?>"
                                     loading="lazy">
                            <?php else : ?>
                                <div class="team-photo-initials">
                                    <?php
                                    $parts    = explode( ' ', wp_strip_all_tags( $m['name'] ) );
                                    $initials = '';
                                    foreach ( $parts as $p ) {
                                        if ( ctype_alpha( $p[0] ) ) $initials .= strtoupper( $p[0] );
                                    }
                                    echo esc_html( substr( $initials, -2 ) );
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="team-name-block">
                            <h3><?php echo esc_html( $m['name'] ); ?></h3>
                            <span class="team-role"><?php echo esc_html( $m['role'] ); ?></span>
                        </div>
                    </div>

                    <!-- Bio + specializations -->
                    <div class="team-info-col">
                        <p class="team-bio"><?php echo esc_html( $m['bio'] ); ?></p>
                        <h4 class="team-skills-heading">Areas of Expertise</h4>
                        <ul class="team-skills">
                            <?php foreach ( $m['skills'] as $skill ) : ?>
                            <li><i class="fa-solid fa-check" aria-hidden="true"></i><?php echo esc_html( $skill ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- CALLBACK BANNER -->
<section class="cta-banner-section">
    <div class="container banner-grid">
        <div class="banner-text">
            <h3>YOU FOCUS ON WHAT YOU DO THE BEST!</h3>
            <h2>And leave all the compliance hassles to us</h2>
            <p>From tax planning or annual audits to monthly bookkeeping and GST return filing for small, medium, or large-scale enterprises, our experts manage it all. With years of hands-on experience, we operate like your in-house finance team.</p>
        </div>
        <div class="banner-form-box">
            <div class="form-wrapper">
                <h3>Request a Callback</h3>
                <p>Send your message and our expert will call you shortly.</p>
                <form id="callbackForm" class="interactive-form">
                    <div class="form-group">
                        <input type="text" id="cbName" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" id="cbPhone" name="phone" placeholder="Phone Number" required>
                    </div>
                    <div class="form-group">
                        <input type="email" id="cbEmail" name="email" placeholder="Email Address" required>
                    </div>
                    <button type="submit" class="btn btn-accent btn-full">Send Callback Request <i class="fa-solid fa-paper-plane"></i></button>
                </form>
                <div class="form-success" id="cbSuccess" style="display:none; text-align:center;">
                    <i class="fa-solid fa-circle-check"></i>
                    <h4>Request Sent!</h4>
                    <p>We will call you back shortly.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CONTENT ACCORDION (SEO CONTENT) -->
<section class="content-accordion-section">
    <div class="container">
        <div class="section-header align-center">
            <span class="sub-title">Learn More</span>
            <h2>Detailed Insights &amp; Advisory Info</h2>
            <div class="heading-line"></div>
        </div>
        <div class="accordion-container">
            <div class="accordion-item active">
                <button class="accordion-header">
                    <span>Chartered Accountant In Pune, India</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="accordion-content">
                    <p>A. N. Bhutada &amp; Co. is a trusted and versatile CA firm in Pune, India. We aim to provide top-quality services in Auditing and Taxation, Company Registration, Income Tax Consulting, Outsourced Accounting, Outsourced Payroll, NRI Taxation, Secretarial Services, GST filing, GST Consultancy, Direct &amp; Indirect Taxation, DGFT Services, STPI Consulting, Corporate Finance Advisory, and Import Export Tax Benefits.</p>
                </div>
            </div>
            <div class="accordion-item">
                <button class="accordion-header">
                    <span>Why You Need to Hire a CA Firm in Pune?</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="accordion-content">
                    <p>Pune is the second fastest-growing city in Maharashtra after Mumbai. It is a hub of education, manufacturing, and technology. Starting a business in Pune's competitive MIDC zones requires strong structural planning. A seasoned CA firm helps you choose the right business structure (LLP vs. Private Limited) and streamlines accounting, GST filings, payroll processing, and regulatory audits under one roof.</p>
                </div>
            </div>
            <div class="accordion-item">
                <button class="accordion-header">
                    <span>Top Chartered Accountant in Pune – A N Bhutada &amp; CO</span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <div class="accordion-content">
                    <p>Our firm stands out due to our comprehensive, multi-disciplinary service model. Partnering with A N Bhutada &amp; Co ensures you get company formation, tax returns, audits, and Registrar of Companies (ROC) compliance managed by dedicated resources. We allocate dedicated tax and account executives to manage your TDS filings, tax payments, and non-disclosure-backed information security.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- GOOGLE REVIEWS CAROUSEL -->
<section class="reviews-section">
    <div class="container">
        <div class="section-header align-center">
            <span class="sub-title">Testimonials</span>
            <h2>What Our Clients Say on Google</h2>
            <div class="heading-line"></div>
        </div>
        <div class="carousel-wrapper">
            <button class="carousel-nav prev" id="revPrev" aria-label="Previous Review"><i class="fa-solid fa-arrow-left"></i></button>
            <div class="carousel-track-container">
                <div class="carousel-track" id="revTrack">
                    <div class="review-slide">
                        <div class="review-card">
                            <div class="review-header">
                                <div class="avatar" style="background-color: #3190E7;">AD</div>
                                <div><h4>Aniket Dandge</h4><span class="review-date">October 8, 2021</span></div>
                                <img src="https://www.anbca.com/wp-content/plugins/wp-google-places-review-slider/public/partials/imgs/google_small_icon.png" alt="Google" class="google-badge">
                            </div>
                            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            <p class="review-text">"Positive: Professionalism, Quality, Responsiveness, Value. Excellent support and expert CA services in Pune."</p>
                        </div>
                    </div>
                    <div class="review-slide">
                        <div class="review-card">
                            <div class="review-header">
                                <div class="avatar" style="background-color: #00bcd4;">BF</div>
                                <div><h4>Brijesh Fargose</h4><span class="review-date">November 12, 2021</span></div>
                                <img src="https://www.anbca.com/wp-content/plugins/wp-google-places-review-slider/public/partials/imgs/google_small_icon.png" alt="Google" class="google-badge">
                            </div>
                            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            <p class="review-text">"Great service good job. Very helpful and knowledgeable staff for company registration."</p>
                        </div>
                    </div>
                    <div class="review-slide">
                        <div class="review-card">
                            <div class="review-header">
                                <div class="avatar" style="background-color: #ff9800;">PS</div>
                                <div><h4>Pradip Shinde</h4><span class="review-date">December 2, 2021</span></div>
                                <img src="https://www.anbca.com/wp-content/plugins/wp-google-places-review-slider/public/partials/imgs/google_small_icon.png" alt="Google" class="google-badge">
                            </div>
                            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            <p class="review-text">"Positive: Professionalism, Quality, Responsiveness, Value. Outstanding auditing and taxation consultant in Pune."</p>
                        </div>
                    </div>
                    <div class="review-slide">
                        <div class="review-card">
                            <div class="review-header">
                                <div class="avatar" style="background-color: #9c27b0;">GE</div>
                                <div><h4>GlobeNet Computer Education</h4><span class="review-date">September 25, 2021</span></div>
                                <img src="https://www.anbca.com/wp-content/plugins/wp-google-places-review-slider/public/partials/imgs/google_small_icon.png" alt="Google" class="google-badge">
                            </div>
                            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></div>
                            <p class="review-text">"Positive: Professionalism, Quality, Responsiveness, Value. Extremely happy with their corporate tax filing support."</p>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-nav next" id="revNext" aria-label="Next Review"><i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </div>
</section>

<!-- FAQS SECTION -->
<section class="faqs-section">
    <div class="container">
        <div class="section-header align-center">
            <span class="sub-title">FAQ</span>
            <h2>Frequently Asked Questions</h2>
            <div class="heading-line"></div>
            <p>Find quick answers to common queries regarding CA consulting, taxes, and corporate registrations.</p>
        </div>
        <div class="faq-grid">
            <div class="faq-col">
                <?php
                $faqs_col1 = array(
                    array( '1', 'Which is the best CA firm in Pune?', 'AN Bhutada &amp; Co is widely recognized as a top CA firm in Pune. We are known for delivering accounting, company registration, LLP formation, tax auditing, GST return filing, and foreign subsidiary setup services with high accuracy.' ),
                    array( '2', 'What does a Chartered Accountant do?', 'A Chartered Accountant (CA) is a certified financial expert who manages bookkeeping, statutory audits, income tax filings, corporate compliance, and budgets. They audit financial statements to ensure legal compliance and provide strategic investment and tax planning advisory.' ),
                    array( '3', 'What does a CA firm do?', 'A CA firm offers integrated financial services to businesses and individuals, including auditing, tax optimization, corporate compliance filings, accounting outsourcing, payroll processing, forensic investigation, valuation, and general financial consulting.' ),
                    array( '4', 'Why do companies need Chartered Accountants?', 'Companies hire CAs to maintain regulatory compliance, structure tax liability efficiently, prepare audit-ready balance sheets, manage financial risks, and consult on growth planning, mergers, and financial restructuring.' ),
                    array( '5', 'Can a CA firm help in filing an income tax return?', 'Yes. CA firms specialize in individual and corporate tax filings. They review income sources, apply legal deductions, handle calculations, submit ITR forms, and represent clients in case of queries from the Income Tax department.' ),
                    array( '6', 'Why you should hire a CA for your business?', 'Hiring a CA ensures error-free compliance, tax optimization, risk reduction, structural scalability, professional bookkeeping, audit support, and advisory insights that save business time and resources.' ),
                );
                foreach ( $faqs_col1 as $faq ) :
                ?>
                <div class="faq-item">
                    <button class="faq-header">
                        <span class="faq-num"><?php echo $faq[0]; ?></span>
                        <span><?php echo $faq[1]; ?></span>
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <div class="faq-content"><p><?php echo $faq[2]; ?></p></div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="faq-col">
                <?php
                $faqs_col2 = array(
                    array( '7', 'Can a CA register a company?', 'A CA firm prepares and submits all digital documentation (including MOA/AOA drafts, DSC setup, and PAN/TAN applications) to register your business entity with the Ministry of Corporate Affairs (MCA).' ),
                    array( '8', 'Do we need a CA for company registration?', 'While not legally mandatory to register, having a professional CA handle company registration ensures proper asset classification, correct share structures, tax optimization, and direct transition to ROC compliance.' ),
                    array( '9', 'Do you need a CA for GST filing?', 'Yes, engaging a CA is highly recommended. They ensure correct classification of items under HSN codes, calculate accurate Input Tax Credits (ITC), file correct returns (GSTR-1, 3B, 9), and prevent penalties.' ),
                    array( '10', 'Do you need a CA for LLP registration?', 'A CA facilitates drafting partnership deeds, filing name approvals, obtaining DSC and DIN, and completing the ROC filings required to set up an LLP in India.' ),
                    array( '11', 'Why is a Chartered Accountant important?', 'A CA acts as a gatekeeper of your business\'s financial integrity. They prevent legal non-compliance penalties, optimize tax planning legal structures, verify ledgers, and provide investors with audited transparency.' ),
                    array( '12', 'Do you need a CA for Foreign Company Subsidiary Registration?', 'Yes. Setting up a foreign subsidiary involves FEMA regulations, RBI reporting, MCA approvals, and international transfer pricing rules. A CA specializing in corporate taxation is vital to manage this compliance chain.' ),
                );
                foreach ( $faqs_col2 as $faq ) :
                ?>
                <div class="faq-item">
                    <button class="faq-header">
                        <span class="faq-num"><?php echo $faq[0]; ?></span>
                        <span><?php echo $faq[1]; ?></span>
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <div class="faq-content"><p><?php echo $faq[2]; ?></p></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- PARTNERS MARQUEE -->
<section class="partners-section">
    <div class="container">
        <h3 class="marquee-title">We work with leading accounting platforms</h3>
        <div class="marquee-wrapper">
            <div class="marquee-track">
                <div class="marquee-slide"><img src="https://www.anbca.com/wp-content/uploads/2019/01/tally.jpg" alt="Tally"></div>
                <div class="marquee-slide"><img src="https://www.anbca.com/wp-content/uploads/2019/01/wave.jpg" alt="Wave Apps"></div>
                <div class="marquee-slide"><img src="https://www.anbca.com/wp-content/uploads/2019/01/winman.jpg" alt="Winman"></div>
                <div class="marquee-slide"><img src="https://www.anbca.com/wp-content/uploads/2019/01/zohobooks.jpg" alt="Zoho Books"></div>
                <div class="marquee-slide"><img src="https://www.anbca.com/wp-content/uploads/2019/01/profitbooks.jpg" alt="Profit Books"></div>
                <div class="marquee-slide"><img src="https://www.anbca.com/wp-content/uploads/2019/01/quickbooks.jpg" alt="QuickBooks"></div>
                <!-- Duplicated for seamless loop -->
                <div class="marquee-slide"><img src="https://www.anbca.com/wp-content/uploads/2019/01/tally.jpg" alt="Tally"></div>
                <div class="marquee-slide"><img src="https://www.anbca.com/wp-content/uploads/2019/01/wave.jpg" alt="Wave Apps"></div>
                <div class="marquee-slide"><img src="https://www.anbca.com/wp-content/uploads/2019/01/winman.jpg" alt="Winman"></div>
                <div class="marquee-slide"><img src="https://www.anbca.com/wp-content/uploads/2019/01/zohobooks.jpg" alt="Zoho Books"></div>
                <div class="marquee-slide"><img src="https://www.anbca.com/wp-content/uploads/2019/01/profitbooks.jpg" alt="Profit Books"></div>
                <div class="marquee-slide"><img src="https://www.anbca.com/wp-content/uploads/2019/01/quickbooks.jpg" alt="QuickBooks"></div>
            </div>
        </div>
    </div>
</section>

