<?php

 


class HFileViewer extends HWindow
{
    private $file_wrapper;
    private $title;
    private $file;
 
    public function setFile($file, $title = '')
    {

        $ext = explode('.', $file);
        $ext = strtoupper($ext[sizeof($ext) - 1]);
        (empty($title)) ? ($title = "PDF Documentos Fiscais") : ('1.3');

        $this->file = $file;
        $this->title = $title;
        if (in_array($ext, array('PDF', 'HTM', 'HTML', 'PHP', 'PHTML'))) {
            $this->file_wrapper = new TElement('object');
            $this->file_wrapper->{'id'} = 'pdf_view_' . mt_rand(1000000000, 1999999999);
            $this->file_wrapper->{'data'} = $this->file;
            $this->file_wrapper->{'style'} = "text-align:center;display:inline;width:100%;height:100%;";
        } else {
            $this->file_wrapper = FALSE;
        }
    }

    public function show()
    {
        if (is_object($this->file_wrapper)) {
            $c3 = new THyperLink('Baixar Relatório', $this->file, 'white', 10, '', 'fa:download white');
            $c3->class = 'btn btn-success';

            $vbox = new TVBox;
            $vbox->style = 'text-align:center;width: 100%';
            $vbox->add($c3);

            $w = TWindow::create($this->title, "0.8", "0.8");
            $w->setStackOrder(10000);
            $w->add($this->file_wrapper);
            $w->add($vbox);
            $w->show();
        } else {
            TPage::openFile($this->file);
        }
    }

    public function download()
    {
        TPage::openFile($this->file);
    }
}
