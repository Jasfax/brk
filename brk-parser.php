<?php

class brkParser {
	
	public $fileLoc = '';
	
	public function __construct( $fileLoc ) {
		
		$this->fileLoc = $fileLoc;

	}
	
	// Parsing the file itself
	public function parse() {
		
		$fileLoc = $this->fileLoc;
		
		if (file_exists($fileLoc)) {
			
			$data = file_get_contents($fileLoc);
			
			// Bad method to check :/
			
			$data = explode("[bricks]", $data);

			if (count($data) > 1) {
				
				$data = explode("[end]", $data[1]);

				if (count($data) > 1) {
					
					$placeArray = [
						"Blocks" => []
					];
				
					$blocks = explode ('="', $data[0]);
					
					// get out of array because it will always be empty (at least should be)
					unset($blocks[0]);
					
					$shapeValues = [
						0 => "Unknown",
						1 => "Block",
						2 => "Cylinder",
						3 => "Cone",
						4 => "Ball"
					];
					
					foreach ($blocks as $block) {
						
						$block = str_replace("\r\n", "", $block);
						
						$block = explode(" ", $block);

						// Locations
						$X_Loc = $block[1];
						$Z_Loc = $block[2];
						$Y_Loc = $block[3];
						// Size
						$X_Size = $block[4];
						$Z_Size = $block[5];
						$Y_Size = $block[6];
						// Misc.
						$Color = dechex($block[7]);
						$Alpha = $block[8];
						$Shape = strtr( $block[9], $shapeValues );
						$ShapeInt = $block[9];

						
						$placeArray['Blocks'][] = [ 
							"X" => $X_Loc,
							"Y" => $Y_Loc,
							"Z" => $Z_Loc,
							"X_Size" => $X_Size,
							"Y_Size" => $Y_Size,
							"Z_Size" => $Z_Size,
							"Color" => $Color,
							"Alpha_Transparency" => $Alpha,
							"Shape" => $Shape,
							"Shape_Int" => $ShapeInt
						];
					}
					
					return $placeArray;

				} else {
					return false;
				}
				
			} else {
				return false;
			}
			
		} else {
			return false;
		}
		
	}
	
}

?>
