<?php
    require('../connection.php');
    $position = $_GET["position"];
    $results = mysqli_query($con, "SELECT * FROM tbCandidates where candidate_position='$position'");
    $row1 = mysqli_fetch_array($results); // for the first candidate
    $row2 = mysqli_fetch_array($results); // for the second candidate
    if ($row1){
        $candidate_name_1=$row1['candidate_name']; // first candidate name
        $candidate_1=$row1['candidate_cvotes']; // first candidate votes
    }

    if ($row2){
        $candidate_name_2=$row2['candidate_name']; // second candidate name
        $candidate_2=$row2['candidate_cvotes']; // second candidate votes
    }
    $totalVotes = $candidate_2+$candidate_1;
    ob_start();
    require('../pdfGen/fpdf.php');
    $pdf=new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,50,'',0,1,'C');
    $pdf->Cell(0,0,'Welcome to Online Election Result Generator',0,1, 'C');
    $pdf->Cell(0,20,"Total Votes: $totalVotes " ,0,0, 'C');
    $pdf->Ln();
    $pdf->Cell(0,20,"Candidate Name: $candidate_name_1 ",0,0, 'C');
    $pdf->Ln();
    $pdf->Cell(0,5,"Votes: $candidate_1 " ,0,0, 'C');
    $pdf->Ln();
    $pdf->Cell(0,20,"Candidate Name: $candidate_name_2 ",0,0, 'C');
    $pdf->Ln();
    $pdf->Cell(0,5,"Votes: $candidate_2 " ,0,0, 'C');
    $pdf->Ln();
    if($candidate_1 > $candidate_2){
        $pdf->Cell(0,20,"Winner: $candidate_name_1 " ,0,0, 'C');
    }
    else if($candidate_1 < $candidate_2){
        $pdf->Cell(0,20,"Winner: $candidate_name_2 " ,0,0, 'C');
    }
    else{
        $pdf->Cell(0,20,"Votes are same. So we have no WINNER!!!" ,0,1, 'C');
    }
    $pdf->Ln();
    $pdf->Output();
    ob_end_flush(); 
?>
