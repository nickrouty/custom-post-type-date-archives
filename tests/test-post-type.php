<?php
/**
 * Tests for dependencies and various plugin functions
 */
class KM_CPTDA_Post_Type extends CPTDA_UnitTestCase {

	/**
	 * Set up.
	 */
	function setUp() {
		parent::setUp();
		$this->set_permalink_structure( 'blog/%postname%/' );
	}

	/**
	 * Reset post type on teardown.
	 */
	function tearDown() {
		parent::tearDown();
		$this->unregister_post_type();
	}

	/**
	 * Test slug with front (blog)
	 *
	 * @depends KM_CPTDA_Tests_Testcase::test_init
	 */
	function test_cpt_slug_with_front() {
		$this->init();
		$slug = cptda_get_post_type_base( 'cpt' );
		$this->assertEquals( 'blog/cpt', $slug );
	}

	/**
	 * Test slug
	 *
	 * @depends KM_CPTDA_Tests_Testcase::test_init
	 */
	function test_cpt_slug() {
		$this->set_permalink_structure( '/%postname%/' );
		$this->init();
		$slug = cptda_get_post_type_base( 'cpt' );
		$this->assertEquals( 'cpt', $slug );
	}

	/**
	 * Test rewrite slug
	 *
	 * @depends KM_CPTDA_Tests_Testcase::test_init
	 */
	function test_cpt_rewrite_slug() {
		$this->init( 'cpt', 'publish', array( 'slug' => 'rewrite', 'with_front' => true ) );
		$slug = cptda_get_post_type_base( 'cpt' );
		$this->assertEquals( 'blog/rewrite', $slug );
	}

	/**
	 * Test rewrite slug without front
	 *
	 * @depends KM_CPTDA_Tests_Testcase::test_init
	 */
	function test_cpt_rewrite_slug_without_front() {
		$this->init( 'cpt', 'publish', array( 'slug' => 'rewrite', 'with_front' => false ) );
		$plugin = cptda_date_archives();
		$slug = cptda_get_post_type_base( 'cpt' );
		$this->assertEquals( 'rewrite', $slug );
	}

	/**
	 * Test rewrite set to false
	 *
	 * @depends KM_CPTDA_Tests_Testcase::test_cpt_setup
	 */
	function test_cpt_rewrite_slug_rewrite_false() {
		global $wp_rewrite;
		$args = array( 'public' => true, 'has_archive' => true, 'rewrite' => false );
		register_post_type( 'cpt', $args );
		$this->cpt_setup( 'cpt' );
		$post_type = get_post_type_object( 'cpt' );
		$slug = cptda_get_post_type_base( 'cpt' );
		$this->assertEquals( '', $slug );
	}

}
