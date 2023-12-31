<div id="job-manager-job-applications">
    <?php if ( jobhunt_is_woocommerce_activated() ) {
		do_action( 'woocommerce_account_navigation' );
	} ?>
    <div class="job-manager-job-applications">
        <a href="<?php echo esc_url( add_query_arg( 'download-csv', true ) ); ?>" class="job-applications-download-csv"><?php esc_html_e( 'Download CSV', 'jobhunt' ); ?></a>
        <p><?php printf( wp_kses_post( __( 'The job applications for "%s" are listed below.', 'jobhunt' ) ), '<a href="' . esc_url( get_permalink( $job_id ) ) . '">' . get_the_title( $job_id ) . '</a>' ); ?></p>
        <div class="job-applications">
            <form class="filter-job-applications" method="GET">
                <p>
                    <select name="application_status">
                        <option value=""><?php esc_html_e( 'Filter by status', 'jobhunt' ); ?>...</option>
                        <?php foreach ( get_job_application_statuses() as $name => $label ) : ?>
                            <option value="<?php echo esc_attr( $name ); ?>" <?php selected( $application_status, $name ); ?>><?php echo esc_html( $label ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </p>
                <p>
                    <select name="application_orderby">
                        <option value=""><?php esc_html_e( 'Newest first', 'jobhunt' ); ?></option>
                        <option value="name" <?php selected( $application_orderby, 'name' ); ?>><?php esc_html_e( 'Sort by name', 'jobhunt' ); ?></option>
                        <option value="rating" <?php selected( $application_orderby, 'rating' ); ?>><?php esc_html_e( 'Sort by rating', 'jobhunt' ); ?></option>
                    </select>
                    <input type="hidden" name="action" value="show_applications" />
                    <input type="hidden" name="job_id" value="<?php echo absint( $_GET['job_id'] ); ?>" />
                    <?php if ( ! empty( $_GET['page_id'] ) ) : ?>
                        <input type="hidden" name="page_id" value="<?php echo absint( $_GET['page_id'] ); ?>" />
                    <?php endif; ?>
                </p>
            </form>
            <ul class="job-applications">
                <?php foreach ( $applications as $application ) : ?>
                    <li class="job-application" id="application-<?php echo esc_attr( $application->ID ); ?>">
                        <header>
                            <?php job_application_header( $application ); ?>
                        </header>
                        <section class="job-application-content">
                            <?php job_application_meta( $application ); ?>
                            <?php job_application_content( $application ); ?>
                        </section>
                        <section class="job-application-edit">
                            <?php job_application_edit( $application ); ?>
                        </section>
                        <section class="job-application-notes">
                            <?php job_application_notes( $application ); ?>
                        </section>
                        <footer>
                            <?php job_application_footer( $application ); ?>
                        </footer>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php get_job_manager_template( 'pagination.php', array( 'max_num_pages' => $max_num_pages ) ); ?>
        </div>
    </div>
</div>