<?php

class RememberFilter extends sfFilter
{
    public function execute($filterChain)
    {
        if ( $this->isFirstCall() ) $this->getContext()->getUser()->checkRemember();
        $filterChain->execute();
    }
}  