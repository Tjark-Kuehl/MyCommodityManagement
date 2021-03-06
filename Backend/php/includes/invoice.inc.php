<?php

function generatePDF(array $rows, string $rechnungsname)
{
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT);

    $lineHeight = 5;

    // set document information
    $pdf->SetCreator(PDF_CREATOR);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT, true);

    // remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // set auto page breaks
    $pdf->SetAutoPageBreak(true, $pdf->GetFooterMargin());

    // set font
    $pdf->SetFont('helvetica', 'R', 10);

    function insertTableHeader(&$pdf, $kundenNr, $kundenName, $erstelldatum, $lineHeight)
    {
        $pdf->SetFont('helvetica', 'R', 14);
        $pdf->MultiCell(0, $lineHeight, "Auftrag", 0, 'L');

        $pdf->SetFont('helvetica', 'R', 10);
        $pdf->MultiCell(0, $lineHeight, "Erstellt am: " . (new GermanDate($erstelldatum))->getGermanDate(), 0, 'L');

        $pdf->Ln($lineHeight);

        $pdf->MultiCell(0, $lineHeight, "Kunden-Nr.: $kundenNr", 0, 'L');

        $pdf->MultiCell(0, $lineHeight, $kundenName, 0, 'L');
    }

    function insertTableRow(&$pdf, $array, $widths = null, $underline = false, $alignCell = false)
    {
        $currentPage = $pdf->getPage();
        $pageDefaultWidth = 210 - PDF_MARGIN_LEFT - PDF_MARGIN_RIGHT;
        $columnMargin = 2;

        // Subtract column margins
        $pageWidth = $pageDefaultWidth - (sizeof($array) * $columnMargin);

        // Fill width array with even sizes if null
        if (is_null($widths)) {
            $widths = array();
            for ($i = 0; $i < sizeof($array); $i++) {
                $widths[$i] = $pageWidth / sizeof($array);
            }
        }

        // Iterate values
        $firstColumn = true;
        $y = $pdf->GetY();
        $highestY = $y;
        $x = PDF_MARGIN_LEFT;
        foreach ($array as $key => $val) {
            if ($firstColumn === false) {
                $x += (($widths[$key - 1] / 100) * $pageWidth) + $columnMargin;
            }

            if ($pdf->getPage() != $currentPage) {
                $pdf->SetXY($x, PDF_MARGIN_TOP);
                // Bei Seitenumbruch wird sonst der letzte wert mit dem die Seite umgebrochen wurde irgnoriert
                if ($highestY > 200) {
                    $highestY = $pdf->GetY();
                }
            } else {
                $pdf->SetXY($x, $y);
            }

            if ($alignCell !== false) {
                $pdf->MultiCell(($widths[$key] / 100) * $pageWidth, 5, trim($val), 0, $alignCell[$key]);
            } else {
                $pdf->MultiCell(($widths[$key] / 100) * $pageWidth, 5, trim($val), 0, 'L');
            }

            $highestY = max($highestY, $pdf->GetY());
            $firstColumn = false;
        }
        $pdf->SetY($highestY);
        // Flags
        if ($underline === true) {
            $pdf->SetFillColor(200, 200, 200);
            $pdf->Rect(PDF_MARGIN_LEFT, $highestY, $pageDefaultWidth, 0.5, 'F');
            $pdf->SetY($highestY + 2);
        }
    }

    function formattedNumber($nbr)
    {
        return str_replace('.', ',', sprintf("%.2f", $nbr));
    }

    /**
     * Holt sich das erste Element für die Headerdaten
     */
    $firstEl = getFirstElement(getFirstElement($rows));

    foreach ($rows as $auftragsposition) {
        /**
         * Variabeln
         */
        $tableWidths = array(70, 15, 15);
        $alignCells = array("L", "R", "R");

        /**
         * Seite hinzufügen
         */
        $pdf->AddPage();

        /**
         * Fügt den Table Header hinzu
         */
        insertTableHeader($pdf, $firstEl->kundennr, $firstEl->kundenname, $firstEl->erstellt_zeit, $lineHeight);

        $pdf->SetFont('helvetica', 'B', 10);

        $pdf->Ln($lineHeight);
        insertTableRow(
            $pdf,
            array("Beschreibung", "Menge", "Preis"),
            $tableWidths,
            true,
            $alignCells
        );

        $priceSum = 0;
        $pdf->SetFont('helvetica', 'R', 10);

        foreach ($auftragsposition as $item) {
            $price = $item->preis * $item->menge;

            insertTableRow(
                $pdf,
                array(
                    $item->bezeichnung, $item->menge,
                    formattedNumber($price) . " €",
                ),
                $tableWidths,
                false,
                $alignCells
            );

            $pdf->Ln(1);

            $priceSum += $price;
        }

        // Gesamt
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->SetY($pdf->GetY() + 10);

        // zu berechnen sind
        insertTableRow(
            $pdf,
            array("Summe:", "", formattedNumber($priceSum) . " €"),
            $tableWidths,
            false,
            $alignCells
        );
    }

    $pdf->Output("/php/pdf/{$rechnungsname}", 'F');
}
