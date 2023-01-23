<?php

/**
 * Nectar Animations
 *
 * 
 * @package Salient Core
 * @version 1.9
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Nectar Lazy Images.
 */
if (!class_exists('NectarAnimations')) {

    class NectarAnimations
    {

        public static $devices = array('desktop', 'tablet', 'phone');
        public $offsets = array('start' => '0', 'end' => '50');
        public $array_animations = array();
        public $config = array();
        public $json = array();

        /**
         * Constructor.
         */
        public function __construct($atts)
        {
            $this->atts = $atts;
            $this->gather_all_animations();
            $this->calculate_offsets();
            $this->encode_data();
        }

        public function gather_all_animations()
        {

            foreach (self::$devices as $device) {
                $this->clip_path($device);
            }

        }

        public function encode_data()
        {   
            // base config.
            if ( isset($this->atts['animation_inner_selector']) && !empty($this->atts['animation_inner_selector']) ) {
                $this->config['inner_selector'] = $this->atts['animation_inner_selector'];
            }

            $this->json = wp_json_encode(array(
                'animations' => $this->array_animations,
                'offsets' => $this->offsets,
                'config' => $this->config
            ));
        }

        public function calculate_offsets() 
        {   
            if ( isset($this->atts['animation_trigger_offset']) && strpos($this->atts['animation_trigger_offset'], ',') !== false ) {
                $kaboom = explode(',', $this->atts['animation_trigger_offset']);
                $this->offsets['start'] = $kaboom[0];
                $this->offsets['end'] = $kaboom[1];
            }

            if ( isset($this->atts['animation_trigger_origin']) ) {
                $this->offsets['origin'] = $this->atts['animation_trigger_origin'];
            }
        }

        public function clip_path($device)
        {

            // Clip path.
            $clip_params_start = array();
            $clip_params_start['clip_start_t'] = 'clip_path_start_top';
            $clip_params_start['clip_start_r'] = 'clip_path_start_right';
            $clip_params_start['clip_start_b'] = 'clip_path_start_bottom';
            $clip_params_start['clip_start_l'] = 'clip_path_start_left';

            $clip_params_end = array();
            $clip_params_end['clip_end_t'] = 'clip_path_end_top';
            $clip_params_end['clip_end_r'] = 'clip_path_end_right';
            $clip_params_end['clip_end_b'] = 'clip_path_end_bottom';
            $clip_params_end['clip_end_l'] = 'clip_path_end_left';

            $clip_consolidated_start_vals = '';
            $clip_consolidated_end_vals = '';

            foreach ($clip_params_start as $param) {

                //// Starting.
                if (isset($this->atts[$param . '_' . $device]) && strlen($this->atts[$param . '_' . $device]) > 0) {
                    $clip_consolidated_start_vals .= nectar_css_sizing_units($this->atts[$param . '_' . $device]) . ' ';
                } else {
                    $clip_consolidated_start_vals .= '0 ';
                }

            } // end clip path foreach

            foreach ($clip_params_end as $param) {

                //// Ending.
                if ( isset($this->atts[$param . '_' . $device]) && strlen($this->atts[$param . '_' . $device]) > 0 ) {
                    $clip_consolidated_end_vals .= nectar_css_sizing_units($this->atts[$param . '_' . $device]) . ' ';
                } else {
                    $clip_consolidated_end_vals .= '0 ';
                }

            } // end clip path foreach


            $start_roundness_val = '0';
            if (isset($this->atts['clip_path_start_roundness']) && !empty($this->atts['clip_path_start_roundness']) && $clip_consolidated_start_vals !== '0 0 0 0 ') {
                $start_roundness_val = nectar_css_sizing_units($this->atts['clip_path_start_roundness']);
            }

            $end_roundness_val = '0.1px';
            if (isset($this->atts['clip_path_end_roundness']) && !empty($this->atts['clip_path_end_roundness'])  && $clip_consolidated_end_vals !== '0 0 0 0 ') {
                $end_roundness_val = nectar_css_sizing_units($this->atts['clip_path_end_roundness']);
            }

             // Combine and stroe.
            
            $this->array_animations[$device]['clipPath']['start'] = 'inset('.$clip_consolidated_start_vals.'round '.$start_roundness_val.')';
            $this->array_animations[$device]['clipPath']['end'] = 'inset('.$clip_consolidated_end_vals.'round '.$end_roundness_val.')';
        


        } // end clip path.


    }
}
