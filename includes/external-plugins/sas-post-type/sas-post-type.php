<?php
/**
 * SAS Post Type
 *
 * Used to help create custom post types for Wordpress.
 * @link http://disenialia.com/custom-post-type/custom-post-type.zip
 *
 * @author  UlisesFreitas
 * @link    http://ulisesfreitas.com
 * @version 1.0
 * @license http://www.gnu.org/licenses/gpl-2.0.txt
 */
class Sas_Post_Type {

    /**
     * Post type name.
     *
     * @var string $post_type_name Holds the name of the post type.
     */
    public $post_type_name;

    /**
     * Holds the singular name of the post type. This is a human friendly
     * name, capitalized with spaces assigned on __construct().
     *
     * @var string $singular Post type singular name.
     */
    public $singular;

    /**
     * Holds the plural name of the post type. This is a human friendly
     * name, capitalized with spaces assigned on __construct().
     *
     * @var string $plural Singular post type name.
     */
    public $plural;

    /**
     * Post type slug. This is a robot friendly name, all lowercase and uses
     * hyphens assigned on __construct().
     *
     * @var string $slug Holds the post type slug name.
     */
    public $slug;

    /**
     * User submitted options assigned on __construct().
     *
     * @var array $options Holds the user submitted post type options.
     */
    public $options;

    /**
     * Taxonomies
     *
     * @var array $taxonomies Holds an array of taxonomies associated with the post type.
     */
    public $taxonomies;

    /**
     * Taxonomy settings, an array of the taxonomies associated with the post
     * type and their options used when registering the taxonomies.
     *
     * @var array $taxonomy_settings Holds the taxonomy settings.
     */
    public $taxonomy_settings;

    /**
     * Exisiting taxonomies to be registered after the posty has been registered
     *
     * @var array $exisiting_taxonomies holds exisiting taxonomies
     */
    public $exisiting_taxonomies;

    /**
     * Taxonomy filters. Defines which filters are to appear on admin edit
     * screen used in add_taxonmy_filters_spt().
     *
     * @var array $filters Taxonomy filters.
     */
    public $filters;

    /**
     * Defines which columns are to appear on the admin edit screen used
     * in add_admin_columns_spt().
     *
     * @var array $columns Columns visible in admin edit screen.
     */
    public $columns;

    /**
     * User defined functions to populate admin columns.
     *
     * @var array $custom_populate_columns User functions to populate columns.
     */
    public $custom_populate_columns;

    /**
     * Sortable columns.
     *
     * @var array $sortable Define which columns are sortable on the admin edit screen.
     */
    public $sortable;

    /**
     * Textdomain used for translation. Use the set_textdomain() method to set a custom textdomain.
     *
     * @var string $textdomain Used for internationalising. Defaults to "cpt" without quotes.
     */
    public $textdomain = 'sas-shop';


    /**
     * __construct function.
     *
     * @access public
     * @param mixed $post_type_names
     * @param array $options (default: array())
     * @return void
     */
    function __construct( $post_type_names ,$options = array() ) {

        if ( is_array( $post_type_names ) ) {

            // Add names to object.
            $names = array(
                'singular',
                'plural',
                'slug'
            );

            $this->post_type_name = $post_type_names['post_type_name'];

            foreach ( $names as $name ) {

                if ( isset( $post_type_names[ $name ] ) ) {

                    $this->$name = $post_type_names[ $name ];

                } else {

                    $method = 'get_' . $name;

                    $this->$name = $this->$method();
                }
            }


        } else {

            $this->post_type_name = $post_type_names;
            $this->slug = $this->get_slug_spt();
            $this->plural = $this->get_plural_spt();
            $this->singular = $this->get_singular_spt();
        }

        $this->options = $options;
        $this->add_action( 'init', array( &$this, 'register_spt_taxonomies' ) );
        $this->add_action( 'init', array( &$this, 'register_spt_post_type' ) );
        $this->add_action( 'init', array( &$this, 'register_exisiting_spt_taxonomies' ) );
        $this->add_filter( 'manage_edit-' . $this->post_type_name . '_columns', array( &$this, 'add_admin_columns_spt' ) );
        $this->add_action( 'manage_' . $this->post_type_name . '_posts_custom_column', array( &$this, 'populate_admin_columns_spt' ), 10, 2 );
        $this->add_action( 'restrict_manage_posts', array( &$this, 'add_taxonomy_filters_spt' ) );
        $this->add_filter( 'post_updated_messages', array( &$this, 'updated_messages' ) );
        $this->add_filter( 'bulk_post_updated_messages', array( &$this, 'bulk_updated_messages' ), 10, 2 );
    }


    /**
     * getSPT function.
     *
     * @access public
     * @param mixed $var
     * @return void
     */
    function getSPT( $var ) {

        // If the variable exists.
        if ( $this->$var ) {

            // On success return the value.
            return $this->$var;

        } else {

            // on fail return false
            return false;
        }
    }


    /**
     * setSPT function.
     *
     * @access public
     * @param mixed $var
     * @param mixed $value
     * @return void
     */
    function setSPT( $var, $value ) {

        $reserved = array(
            'config',
            'post_type_name',
            'singular',
            'plural',
            'slug',
            'options',
            'taxonomies'
        );
        if ( ! in_array( $var, $reserved ) ) {
            $this->$var = $value;
        }
    }


    /**
     * add_action function.
     *
     * @access public
     * @param mixed $action
     * @param mixed $function
     * @param int $priority (default: 10)
     * @param int $accepted_args (default: 1)
     * @return void
     */
    function add_action( $action, $function, $priority = 10, $accepted_args = 1 ) {
        add_action( $action, $function, $priority, $accepted_args );
    }


    /**
     * add_filter function.
     *
     * @access public
     * @param mixed $action
     * @param mixed $function
     * @param int $priority (default: 10)
     * @param int $accepted_args (default: 1)
     * @return void
     */
    function add_filter( $action, $function, $priority = 10, $accepted_args = 1 ) {
        add_filter( $action, $function, $priority, $accepted_args );
    }

    /**
     * get_slug_spt function.
     *
     * @access public
     * @param mixed $name (default: null)
     * @return void
     */
    function get_slug_spt( $name = null ) {

        if ( ! isset( $name ) ) {

            $name = $this->post_type_name;
        }
        $name = strtolower( $name );
        $name = str_replace( " ", "-", $name );
        $name = str_replace( "_", "-", $name );

        return $name;
    }


    /**
     * get_plural_spt function.
     *
     * @access public
     * @param mixed $name (default: null)
     * @return void
     */
    function get_plural_spt( $name = null ) {

        if ( ! isset( $name ) ) {

            $name = $this->post_type_name;
        }

        return $this->get_friendly_spt( $name ) . 's';
    }


    /**
     * get_singular_spt function.
     *
     * @access public
     * @param mixed $name (default: null)
     * @return void
     */
    function get_singular_spt( $name = null ) {

        if ( ! isset( $name ) ) {

            $name = $this->post_type_name;

        }

        return $this->get_friendly_spt( $name );
    }

    /**
     * get_friendly_spt function.
     *
     * @access public
     * @param mixed $name (default: null)
     * @return void
     */
    function get_friendly_spt( $name = null ) {

        if ( ! isset( $name ) ) {

            $name = $this->post_type_name;
        }

        return ucwords( strtolower( str_replace( "-", " ", str_replace( "_", " ", $name ) ) ) );
    }


    /**
     * register_spt_post_type function.
     *
     * @access public
     * @return void
     */
    function register_spt_post_type() {

        $plural   = $this->plural;
        $singular = $this->singular;
        $slug     = $this->slug;


        $labels = array(
            'name'               => sprintf( __( '%s', $this->textdomain ), $plural ),
            'singular_name'      => sprintf( __( '%s', $this->textdomain ), $singular ),
            'menu_name'          => sprintf( __( '%s', $this->textdomain ), $plural ),
            'all_items'          => sprintf( __( '%s', $this->textdomain ), $plural ),
            'add_new'            => __( 'Add New', $this->textdomain ),
            'add_new_item'       => sprintf( __( 'Add New %s', $this->textdomain ), $singular ),
            'edit_item'          => sprintf( __( 'Edit %s', $this->textdomain ), $singular ),
            'new_item'           => sprintf( __( 'New %s', $this->textdomain ), $singular ),
            'view_item'          => sprintf( __( 'View %s', $this->textdomain ), $singular ),
            'search_items'       => sprintf( __( 'Search %s', $this->textdomain ), $plural ),
            'not_found'          => sprintf( __( 'No %s found', $this->textdomain ), $plural ),
            'not_found_in_trash' => sprintf( __( 'No %s found in Trash', $this->textdomain ), $plural ),
            'parent_item_colon'  => sprintf( __( 'Parent %s:', $this->textdomain ), $singular )
        );

        $defaults = array(
            'labels' => $labels,
            'public' => true,
            'rewrite' => array(
                'slug' => $slug,
            ),

        );

        $options = array_replace_recursive( $defaults, $this->options );
        $this->options = $options;
        if ( ! post_type_exists( $this->post_type_name ) ) {
            register_spt_post_type( $this->post_type_name, $options );
        }
    }


    /**
     * register_spt_taxonomy function.
     *
     * @access public
     * @param mixed $taxonomy_names
     * @param array $options (default: array())
     * @return void
     */
    function register_spt_taxonomy($taxonomy_names, $options = array()) {

        $post_type = $this->post_type_name;

        $names = array(
            'singular',
            'plural',
            'slug'
        );

        if ( is_array( $taxonomy_names ) ) {

            $taxonomy_name = $taxonomy_names['taxonomy_name'];

            foreach ( $names as $name ) {

                if ( isset( $taxonomy_names[ $name ] ) ) {

                    $$name = $taxonomy_names[ $name ];

                } else {

                    $method = 'get_' . $name;
                    $$name = $this->$method( $taxonomy_name );

                }
            }

        } else  {

            $taxonomy_name = $taxonomy_names;
            $singular = $this->get_singular_spt( $taxonomy_name );
            $plural   = $this->get_plural_spt( $taxonomy_name );
            $slug     = $this->get_slug_spt( $taxonomy_name );

        }

        $labels = array(
            'name'                       => sprintf( __( '%s', $this->textdomain ), $plural ),
            'singular_name'              => sprintf( __( '%s', $this->textdomain ), $singular ),
            'menu_name'                  => sprintf( __( '%s', $this->textdomain ), $plural ),
            'all_items'                  => sprintf( __( 'All %s', $this->textdomain ), $plural ),
            'edit_item'                  => sprintf( __( 'Edit %s', $this->textdomain ), $singular ),
            'view_item'                  => sprintf( __( 'View %s', $this->textdomain ), $singular ),
            'update_item'                => sprintf( __( 'Update %s', $this->textdomain ), $singular ),
            'add_new_item'               => sprintf( __( 'Add New %s', $this->textdomain ), $singular ),
            'new_item_name'              => sprintf( __( 'New %s Name', $this->textdomain ), $singular ),
            'parent_item'                => sprintf( __( 'Parent %s', $this->textdomain ), $plural ),
            'parent_item_colon'          => sprintf( __( 'Parent %s:', $this->textdomain ), $plural ),
            'search_items'               => sprintf( __( 'Search %s', $this->textdomain ), $plural ),
            'popular_items'              => sprintf( __( 'Popular %s', $this->textdomain ), $plural ),
            'separate_items_with_commas' => sprintf( __( 'Seperate %s with commas', $this->textdomain ), $plural ),
            'add_or_remove_items'        => sprintf( __( 'Add or remove %s', $this->textdomain ), $plural ),
            'choose_from_most_used'      => sprintf( __( 'Choose from most used %s', $this->textdomain ), $plural ),
            'not_found'                  => sprintf( __( 'No %s found', $this->textdomain ), $plural ),
        );

        $defaults = array(
            'labels' => $labels,
            'hierarchical' => true,
            'rewrite' => array(
                'slug' => $slug
            )
        );

        $options = array_replace_recursive( $defaults, $options );
        $this->taxonomies[] = $taxonomy_name;
        $this->taxonomy_settings[ $taxonomy_name ] = $options;

    }

    /**
     * register_spt_taxonomies function.
     *
     * @access public
     * @return void
     */
    function register_spt_taxonomies() {

        if ( is_array( $this->taxonomy_settings ) ) {

            foreach ( $this->taxonomy_settings as $taxonomy_name => $options ) {

                if ( ! taxonomy_exists( $taxonomy_name ) ) {

                    register_spt_taxonomy( $taxonomy_name, $this->post_type_name, $options );

                } else {

                    $this->exisiting_taxonomies[] = $taxonomy_name;
                }
            }
        }
    }


    /**
     * register_exisiting_spt_taxonomies function.
     *
     * @access public
     * @return void
     */
    function register_exisiting_spt_taxonomies() {

        if( is_array( $this->exisiting_taxonomies ) ) {
            foreach( $this->exisiting_taxonomies as $taxonomy_name ) {
                register_spt_taxonomy_for_object_type( $taxonomy_name, $this->post_type_name );
            }
        }
    }


    /**
     * add_admin_columns_spt function.
     *
     * @access public
     * @param mixed $columns
     * @return void
     */
    function add_admin_columns_spt( $columns ) {

        if ( ! isset( $this->columns ) ) {

            $new_columns = array();

            if ( is_array( $this->taxonomies ) && in_array( 'post_tag', $this->taxonomies ) || $this->post_type_name === 'post' ) {
                $after = 'tags';
            } elseif( is_array( $this->taxonomies ) && in_array( 'category', $this->taxonomies ) || $this->post_type_name === 'post' ) {
                $after = 'categories';
            } elseif( post_type_supports( $this->post_type_name, 'author' ) ) {
                $after = 'author';
            } else {
                $after = 'title';
            }

            foreach( $columns as $key => $title ) {

                $new_columns[$key] = $title;

                if( $key === $after ) {

                    if ( is_array( $this->taxonomies ) ) {

                        foreach( $this->taxonomies as $tax ) {

                            if( $tax !== 'category' && $tax !== 'post_tag' ) {
                                $taxonomy_object = get_taxonomy( $tax );

                                $new_columns[ $tax ] = sprintf( __( '%s', $this->textdomain ), $taxonomy_object->labels->name );
                            }
                        }
                    }
                }
            }

            $columns = $new_columns;

        } else {

            $columns = $this->columns;
        }

        return $columns;
    }

    /**
     * populate_admin_columns_spt function.
     *
     * @access public
     * @param mixed $column
     * @param mixed $post_id
     * @return void
     */
    function populate_admin_columns_spt( $column, $post_id ) {

        global $post;

        switch( $column ) {

            case ( taxonomy_exists( $column ) ) :

                $terms = get_the_terms( $post_id, $column );

                if ( ! empty( $terms ) ) {

                    $output = array();

                    foreach( $terms as $term ) {

                        $output[] = sprintf(

                            '<a href="%s">%s</a>',

                            esc_url( add_query_arg( array( 'post_type' => $post->post_type, $column => $term->slug ), 'edit.php' ) ),

                            esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, $column, 'display' ) )
                        );

                    }

                    echo join( ', ', $output );

                } else {

                    $taxonomy_object = get_taxonomy( $column );

                    printf( __( 'No %s', $this->textdomain ), $taxonomy_object->labels->name );
                }

            break;

            case 'post_id' :

                echo $post->ID;

            break;

            case ( preg_match( '/^meta_/', $column ) ? true : false ) :

                $x = substr( $column, 5 );

                $meta = get_post_meta( $post->ID, $x );

                echo join( ", ", $meta );

            break;

            case 'icon' :

                $link = esc_url( add_query_arg( array( 'post' => $post->ID, 'action' => 'edit' ), 'post.php' ) );

                if ( has_post_thumbnail() ) {

                    echo '<a href="' . $link . '">';
                        the_post_thumbnail( array(60, 60) );
                    echo '</a>';

                } else {

                    echo '<a href="' . $link . '"><img src="'. site_url( '/wp-includes/images/crystal/default.png' ) .'" alt="' . $post->post_title . '" /></a>';

                }

            break;

            default :

                if ( isset( $this->custom_populate_columns ) && is_array( $this->custom_populate_columns ) ) {

                    if ( isset( $this->custom_populate_columns[ $column ] ) && is_callable( $this->custom_populate_columns[ $column ] ) ) {

                        call_user_func_array(  $this->custom_populate_columns[ $column ], array( $column, $post ) );

                    }
                }

            break;
        }
    }


    /**
     * filters function.
     *
     * @access public
     * @param array $filters (default: array())
     * @return void
     */
    function filters_spt( $filters = array() ) {

        $this->filters = $filters;
    }


    /**
     * add_taxonomy_filters function.
     *
     * @access public
     * @return void
     */
    function add_taxonomy_filters_spt() {

        global $typenow;
        global $wp_query;

        if ( $typenow == $this->post_type_name ) {

            if ( is_array( $this->filters ) ) {

                $filters = $this->filters;

            } else {

                $filters = $this->taxonomies;
            }

            if ( ! empty( $filters ) ) {

                foreach ( $filters as $tax_slug ) {

                    $tax = get_taxonomy( $tax_slug );

                    $args = array(
                        'orderby' => 'name',
                        'hide_empty' => false
                    );

                    $terms = get_terms( $tax_slug, $args );

                    if ( $terms ) {

                        printf( ' &nbsp;<select name="%s" class="postform">', $tax_slug );

                        printf( '<option value="0">%s</option>', sprintf( __( 'Show all %s', $this->textdomain ), $tax->label ) );

                        foreach ( $terms as $term ) {

                            if ( isset( $_GET[ $tax_slug ] ) && $_GET[ $tax_slug ] === $term->slug ) {

                                printf( '<option value="%s" selected="selected">%s (%s)</option>', $term->slug, $term->name, $term->count );

                            } else {

                                printf( '<option value="%s">%s (%s)</option>', $term->slug, $term->name, $term->count );
                            }
                        }
                        print( '</select>&nbsp;' );
                    }
                }
            }
        }
    }


    /**
     * columns function.
     *
     * @access public
     * @param mixed $columns
     * @return void
     */
    function columns_spt( $columns ) {

        if( isset( $columns ) ) {

            $this->columns = $columns;

        }
    }

    /**
     * populate_column function.
     *
     * @access public
     * @param mixed $column_name
     * @param mixed $callback
     * @return void
     */
    function populate_column_spt( $column_name, $callback ) {

        $this->custom_populate_columns[ $column_name ] = $callback;

    }


    /**
     * sortable function.
     *
     * @access public
     * @param array $columns (default: array())
     * @return void
     */
    function sortable_spt( $columns = array() ) {

        $this->sortable = $columns;
        $this->add_filter( 'manage_edit-' . $this->post_type_name . '_sortable_columns', array( &$this, 'make_columns_sortable_spt' ) );
        $this->add_action( 'load-edit.php', array( &$this, 'load_edit_spt' ) );
    }


    /**
     * make_columns_sortable function.
     *
     * @access public
     * @param mixed $columns
     * @return void
     */
    function make_columns_sortable_spt( $columns ) {

        foreach ( $this->sortable as $column => $values ) {

            $sortable_columns[ $column ] = $values[0];
        }

        $columns = array_merge( $sortable_columns, $columns );

        return $columns;
    }


    /**
     * load_edit_spt function.
     *
     * @access public
     * @return void
     */
    function load_edit_spt() {

        $this->add_filter( 'request', array( &$this, 'sort_columns_spt' ) );

    }


    /**
     * sort_columns function.
     *
     * @access public
     * @param mixed $vars
     * @return void
     */
    function sort_columns_spt( $vars ) {

        foreach ( $this->sortable as $column => $values ) {

            $meta_key = $values[0];

            if( taxonomy_exists( $meta_key ) ) {

                $key = "taxonomy";

            } else {

                $key = "meta_key";
            }

            if ( isset( $values[1] ) && true === $values[1] ) {

                $orderby = 'meta_value_num';

            } else {

                $orderby = 'meta_value';
            }

            if ( isset( $vars['post_type'] ) && $this->post_type_name == $vars['post_type'] ) {

                if ( isset( $vars['orderby'] ) && $meta_key == $vars['orderby'] ) {

                    $vars = array_merge(
                        $vars,
                        array(
                            'meta_key' => $meta_key,
                            'orderby' => $orderby
                        )
                    );
                }
            }
        }
        return $vars;
    }


    /**
     * menu_icon_spt function.
     *
     * @access public
     * @param string $icon (default: "dashicons-admin-page")
     * @return void
     */
    function menu_icon_spt( $icon = "dashicons-admin-page" ) {

        if ( is_string( $icon ) && stripos( $icon, "dashicons" ) !== false ) {

            $this->options["menu_icon"] = $icon;

        } else {

            $this->options["menu_icon"] = "dashicons-admin-page";
        }
    }


    /**
     * set_textdomain function.
     *
     * @access public
     * @param mixed $textdomain
     * @return void
     */
    function set_textdomain( $textdomain ) {
        $this->textdomain = $textdomain;
    }


    /**
     * updated_messages function.
     *
     * @access public
     * @param mixed $messages
     * @return void
     */
    function updated_messages( $messages ) {

        $post = get_post();
        $singular = $this->singular;

        $messages[$this->post_type_name] = array(
            0 => '',
            1 => sprintf( __( '%s updated.', $this->textdomain ), $singular ),
            2 => __( 'Custom field updated.', $this->textdomain ),
            3 => __( 'Custom field deleted.', $this->textdomain ),
            4 => sprintf( __( '%s updated.', $this->textdomain ), $singular ),
            5 => isset( $_GET['revision'] ) ? sprintf( __( '%2$s restored to revision from %1$s', $this->textdomain ), wp_post_revision_title( (int) $_GET['revision'], false ), $singular ) : false,
            6 => sprintf( __( '%s updated.', $this->textdomain ), $singular ),
            7 => sprintf( __( '%s saved.', $this->textdomain ), $singular ),
            8 => sprintf( __( '%s submitted.', $this->textdomain ), $singular ),
            9 => sprintf(
                __( '%2$s scheduled for: <strong>%1$s</strong>.', $this->textdomain ),
                date_i18n( __( 'M j, Y @ G:i', $this->textdomain ), strtotime( $post->post_date ) ),
                $singular
            ),
            10 => sprintf( __( '%s draft updated.', $this->textdomain ), $singular ),
        );

        return $messages;
    }


    /**
     * bulk_updated_messages function.
     *
     * @access public
     * @param mixed $bulk_messages
     * @param mixed $bulk_counts
     * @return void
     */
    function bulk_updated_messages( $bulk_messages, $bulk_counts ) {

        $singular = $this->singular;
        $plural = $this->plural;

        $bulk_messages[ $this->post_type_name ] = array(
            'updated'   => _n( '%s '.$singular.' updated.', '%s '.$plural.' updated.', $bulk_counts['updated'] ),
            'locked'    => _n( '%s '.$singular.' not updated, somebody is editing it.', '%s '.$plural.' not updated, somebody is editing them.', $bulk_counts['locked'] ),
            'deleted'   => _n( '%s '.$singular.' permanently deleted.', '%s '.$plural.' permanently deleted.', $bulk_counts['deleted'] ),
            'trashed'   => _n( '%s '.$singular.' moved to the Trash.', '%s '.$plural.' moved to the Trash.', $bulk_counts['trashed'] ),
            'untrashed' => _n( '%s '.$singular.' restored from the Trash.', '%s '.$plural.' restored from the Trash.', $bulk_counts['untrashed'] ),
        );

        return $bulk_messages;
    }


    /**
     * flush function.
     *
     * @access public
     * @return void
     */
    function flush_spt() {
        flush_rewrite_rules();
    }
}
