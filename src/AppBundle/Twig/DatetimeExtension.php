<?php
namespace AppBundle\Twig;

class DatetimeExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('datetime', array($this, 'datetimeFilter')),
        );
    }

    public function datetimeFilter($d, $format = "%B %e", $locale)
    {
        if ($d instanceof \DateTime) {
            $d = $d->getTimestamp();
        }
        setlocale("LC_ALL", $locale);
        return utf8_encode(ucfirst(strftime($format, $d)));
    }

    public function getName()
    {
        return 'datetimeExtension';
    }
}

?>