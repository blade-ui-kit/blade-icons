<?php

namespace <YOUR PACKAGE NAME>\Generator\Command;

use BladeUI\Icons\Console\AbstractGenerateCommand;

class GenerateCommand extends AbstractGenerateCommand
{
    protected static string $npmPackage = '<NAME OF ICONS NPM PACKAGE>';

    /**
     * @var array<string, string>
     *
     * @example 'regular' => 'bx-'
     */
    protected static array $iconSets = [
        <YOUR ICON SETS AND THEIR PREFIX>
    ];

    /**
     * This method should be used to normalize SVGs to prepare them for blade-icons.
     *
     * This is fired after copying the SVG to a temp folder, but before putting them in their final place.
     * Any changes to the file should be made in place; so no changes should result in a new file being made.
     *
     * @param string $tempFilepath  This is the full path to the temporary SVG icon file.
     * @param string $iconSet       The icon set that this icon exists in - provided for when SVGs need modifications based on icon set.
     */
    public function normalizeSvgFile(string $tempFilepath, string $iconSet): void
    {
        // Manipulate the SVG file contents as needed
    }
}