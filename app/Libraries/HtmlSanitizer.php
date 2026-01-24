<?php

namespace App\Libraries;

use HTMLPurifier;
use HTMLPurifier_Config;
use HTMLPurifier_URISchemeRegistry;
use HTMLPurifier_AttrDef_Enum;
use HTMLPurifier_AttrDef_CSS_Number;
use HTMLPurifier_AttrDef_CSS_Length;
use HTMLPurifier_AttrDef_CSS_Percentage;
use HTMLPurifier_AttrDef_CSS_Composite;
use HTMLPurifier_AttrDef_CSS_Multiple;

class HtmlSanitizer
{
    private static ?HTMLPurifier $purifier = null;

    public function limpar(?string $html): string
    {
        $html = (string) $html;
        if ($html === '') {
            return '';
        }

        return self::getPurifier()->purify($html);
    }

    private static function getPurifier(): HTMLPurifier
    {
        if (self::$purifier instanceof HTMLPurifier) {
            return self::$purifier;
        }

        self::registerDataScheme();

        $config = HTMLPurifier_Config::createDefault();
        $config->set('Cache.SerializerPath', self::getCachePath());
        $config->set('HTML.DefinitionID', 'inventalab-html');
        $config->set('HTML.DefinitionRev', 2);
        $config->set('HTML.Allowed', implode(',', [
            'p', 'br', 'div', 'span',
            'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
            'ul', 'ol', 'li',
            'strong', 'em', 'b', 'i', 'u', 's', 'sub', 'sup', 'small',
            'blockquote', 'code', 'pre', 'hr',
            'table', 'thead', 'tbody', 'tfoot', 'tr', 'td', 'th',
            'a', 'img', 'iframe', 'figure', 'figcaption',
        ]));
        $config->set('HTML.AllowedAttributes', [
            '*.style',
            '*.class',
            'a.href',
            'a.title',
            'a.target',
            'a.rel',
            'img.src',
            'img.alt',
            'img.title',
            'img.width',
            'img.height',
            'iframe.src',
            'iframe.width',
            'iframe.height',
            'iframe.frameborder',
            'iframe.allowfullscreen',
            'iframe.allow',
            'iframe.referrerpolicy',
            'table.width',
            'table.border',
            'table.cellpadding',
            'table.cellspacing',
            'td.colspan',
            'td.rowspan',
            'th.colspan',
            'th.rowspan',
        ]);
        $config->set('CSS.AllowTricky', true);
        $config->set('HTML.SafeIframe', true);
        $config->set('URI.SafeIframeRegexp', '%^(https?:)?//(www\\.youtube(?:-nocookie)?\\.com/embed/|player\\.vimeo\\.com/video/)%');
        $config->set('URI.AllowedSchemes', [
            'http' => true,
            'https' => true,
            'mailto' => true,
            'data' => true,
        ]);
        $config->set('Attr.AllowedFrameTargets', ['_blank', '_self', '_parent', '_top']);
        $config->set('HTML.Nofollow', true);

        $cssDef = $config->getCSSDefinition();
        if ($cssDef !== null) {
            $cssDef->info['display'] = new HTMLPurifier_AttrDef_Enum([
                'inline',
                'block',
                'list-item',
                'run-in',
                'compact',
                'marker',
                'table',
                'inline-block',
                'inline-table',
                'table-row-group',
                'table-header-group',
                'table-footer-group',
                'table-row',
                'table-column-group',
                'table-column',
                'table-cell',
                'table-caption',
                'none',
                'flex',
                'inline-flex',
            ]);
            $cssDef->info['flex-wrap'] = new HTMLPurifier_AttrDef_Enum([
                'nowrap',
                'wrap',
                'wrap-reverse',
            ]);
            $gapSingle = new HTMLPurifier_AttrDef_CSS_Composite([
                new HTMLPurifier_AttrDef_CSS_Length('0'),
                new HTMLPurifier_AttrDef_CSS_Percentage(true),
            ]);
            $cssDef->info['gap'] = new HTMLPurifier_AttrDef_CSS_Multiple($gapSingle, 2);
            $flexSingle = new HTMLPurifier_AttrDef_CSS_Composite([
                new HTMLPurifier_AttrDef_CSS_Number(true),
                new HTMLPurifier_AttrDef_CSS_Length('0'),
                new HTMLPurifier_AttrDef_CSS_Percentage(true),
                new HTMLPurifier_AttrDef_Enum(['auto', 'none', 'content']),
            ]);
            $cssDef->info['flex'] = new HTMLPurifier_AttrDef_CSS_Multiple($flexSingle, 3);
            $borderRadius = new HTMLPurifier_AttrDef_CSS_Composite([
                new HTMLPurifier_AttrDef_CSS_Percentage(true),
                new HTMLPurifier_AttrDef_CSS_Length('0'),
            ]);
            $cssDef->info['border-radius'] = new HTMLPurifier_AttrDef_CSS_Multiple($borderRadius, 4);
        }

        $def = $config->maybeGetRawHTMLDefinition();
        if ($def !== null) {
            $def->addAttribute('iframe', 'allowfullscreen', 'Bool');
            $def->addAttribute('iframe', 'allow', 'Text');
            $def->addAttribute('iframe', 'referrerpolicy', 'Text');
        }

        self::$purifier = new HTMLPurifier($config);
        return self::$purifier;
    }

    private static function registerDataScheme(): void
    {
        $registry = HTMLPurifier_URISchemeRegistry::instance();
        $registry->register('data', new HtmlSanitizerDataScheme());
    }

    private static function getCachePath(): string
    {
        $path = rtrim(WRITEPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'htmlpurifier';
        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }
        return $path;
    }
}

class HtmlSanitizerDataScheme extends \HTMLPurifier_URIScheme_data
{
    public $allowed_types = [
        'image/jpeg' => true,
        'image/gif' => true,
        'image/png' => true,
        'image/webp' => true,
    ];
}
