<?php
/*
Gibbon, Flexible & Open School System
Copyright (C) 2010, Ross Parker

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

namespace Gibbon\Forms\Input;

use Gibbon\Forms\Traits\MultipleOptionsTrait;

/**
 * Dropdown
 *
 * @version v22
 * @since   v22
 */
class Dropdown extends Input
{
    use MultipleOptionsTrait;

    protected $placeholder;

    /**
     * Adds an initial entry to the select input. Required elements default to 'Please select...'
     * @param   string  $value
     * @return  self
     */
    public function placeholder($value = '')
    {
        $this->placeholder = $value;

        return $this;
    }

    protected function renderOptions($options) {
        $output = '<ul>';

        foreach ($options as $key => $value) {
            $output .= '<li>';
            if (is_array($value)) {
                $output .= '<div>'.$key.'</div>';
                $output .= $this->renderOptions($value);
            } else {
                $output .= '<div class="leaf" id='.$key.'>'.$value.'</div>';
            }

            $output .= '</li>';
        }

        $output .= '</ul>';

        return $output;
    }

    /**
     * Gets the HTML output for this form element.
     * @return  string
     */
    protected function getElement()
    {

        $output = '<ul class="dropdown">';
            $output .= '<input type="hidden" '.$this->getAttributeString().'>';
            $output .= '<li><div id="header">'.$this->placeholder.'</div>';
                $output .= $this->renderOptions($this->options);
            $output .= '</li>';
        $output .= '</ul>';

        $output .= '<script type="text/javascript">
            $(".dropdown").on("click", "div[class=\'leaf\']", function() {
                $(".dropdown div[id=\'header\']").text($(this).text());
                $(".dropdown input").val($(this).prop("id"));
            });
        </script>';

        return $output;
    }
}
