<?php
class vote
	{
		function createBallot($name, $reset){
			include "inc.php";
			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);

			$stmt =$conn->prepare("INSERT INTO ballot (ballotName, ballotReset, ballotCast) VALUES (?,?, 0)");
			$stmt->bind_param("ss", $newName, $newReset);

			$newName = mysqli_real_escape_string($conn, $name);
			$newReset =mysqli_real_escape_string($conn, $reset);

			$stmt->execute();
			$stmt->close();
			$conn->close();

		}
		function createVote($name, $number, $ballot){
				include "inc.php";

			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);

			$stmt =$conn->prepare("INSERT INTO vote (voteName, voteNumber, voteBallot) VALUES (?,?,?)");
			$stmt->bind_param("sii", $newName, $newNumber, $newBallot);

			$newName = mysqli_real_escape_string($conn, $name);
			$newNumber =mysqli_real_escape_string($conn, $number);
			$newBallot =mysqli_real_escape_string($conn, $ballot);


			$stmt->execute();
			$stmt->close();
			$conn->close();

		}
		function createCanidate($name, $vote){
				include "inc.php";

			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);

			$stmt =$conn->prepare("INSERT INTO canidate (canidateName, canidateVote) VALUES (?,?)");
			$stmt->bind_param("si", $newName, $newVote);

			$newName = mysqli_real_escape_string($conn, $name);
			$newVote =mysqli_real_escape_string($conn, $vote);


			$stmt->execute();
			$stmt->close();
			$conn->close();

		}
		function deleteBallot($id){
			include "inc.php";

			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);
	
			$stmt =$conn->prepare("DELETE FROM ballot WHERE ballotID=?");
			$stmt->bind_param("i", $id);

			$stmt->execute();
			$stmt->close();

			$query ="SELECT voteID FROM vote WHERE voteBallot = $id";
			$results = $conn->query($query);
			$returns = $results->fetch_all(MYSQLI_ASSOC);

			foreach($returns as $return){
				$stmt =$conn->prepare("DELETE FROM canidate WHERE canidateVote=?");
				$stmt->bind_param("i", $return['voteID']);

				$stmt->execute();
				$stmt->close();
			}
			$stmt =$conn->prepare("DELETE FROM vote WHERE voteBallot=?");
			$stmt->bind_param("i", $id);

			$stmt->execute();
			$stmt->close();

			$conn->close();
		}
		function deleteVote($id){
			include "inc.php";

			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);
	
			$stmt =$conn->prepare("DELETE FROM vote WHERE voteID=?");
			$stmt->bind_param("i", $id);

			$stmt->execute();
			$stmt->close();

			$stmt =$conn->prepare("DELETE FROM canidate WHERE canidateVote=?");
			$stmt->bind_param("i", $id);

			$stmt->execute();
			$stmt->close();

			$conn->close();
		}
		function deleteCanidate($id){
			include "inc.php";

			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);
	
			$stmt =$conn->prepare("DELETE FROM canidate WHERE canidateID=?");
			$stmt->bind_param("i", $id);

			$stmt->execute();
			$stmt->close();
			$conn->close();
		}
		function updateBallot($name, $reset, $id){
			include "inc.php";
			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);
	
			$stmt =$conn->prepare("UPDATE ballot SET ballotName=?, ballotReset=? WHERE ballotID=$id");
			$stmt->bind_param("ss", $newName, $newReset);

			$newName = mysqli_real_escape_string($conn, $name);
			$newReset =mysqli_real_escape_string($conn, $reset);
			$stmt->execute();
			$stmt->close();
			$conn->close();
		}
		function updateVote($name, $number, $id){
			include "inc.php";
			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);
	
			$stmt =$conn->prepare("UPDATE vote SET voteName=?, voteNumber=? WHERE voteID=$id");
			$stmt->bind_param("si", $newName, $newNumber);

			$newName = mysqli_real_escape_string($conn, $name);
			$newNumber =mysqli_real_escape_string($conn, $number);
			$stmt->execute();
			$stmt->close();
			$conn->close();
		}
		function updateCanidate($name, $id){
			include "inc.php";
			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);
	
			$stmt =$conn->prepare("UPDATE canidate SET canidateName=? WHERE canidateID=$id");
			$stmt->bind_param("s", $newName);

			$newName = mysqli_real_escape_string($conn, $name);
			$stmt->execute();
			$stmt->close();
			$conn->close();
		}
		function fetchBallot(){
			include "inc.php";
			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);
	
			$query ="SELECT * FROM ballot";
			$results = $conn->query($query);
			$return = $results->fetch_all(MYSQLI_ASSOC);
			$conn->close();
			return $return;
		}
		function fetchBallotByID($id){
			include "inc.php";
			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);
	
			$query ="SELECT * FROM ballot WHERE ballotID=$id";
			$results = $conn->query($query);
			$return = $results->fetch_all(MYSQLI_ASSOC);
			$conn->close();
			return $return;
		}
		function fetchVote($id){
			include "inc.php";
			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);
	
			$query ="SELECT * FROM vote WHERE voteBallot=$id";
			$results = $conn->query($query);
			$return = $results->fetch_all(MYSQLI_ASSOC);
			$conn->close();
			return $return;
		}
		function fetchCanidate($id){
			include "inc.php";
			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);
	
			$query ="SELECT * FROM canidate WHERE canidateVote=$id ORDER BY canidateCount DESC";
			$results = $conn->query($query);
			$return = $results->fetch_all(MYSQLI_ASSOC);
			$conn->close();
			return $return;
		}
		function fetchCanidateAlpha($id){
			include "inc.php";
			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);
	
			$query ="SELECT * FROM canidate WHERE canidateVote=$id";
			$results = $conn->query($query);
			$return = $results->fetch_all(MYSQLI_ASSOC);
			$conn->close();
			return $return;
		}
		function fetchCanidateSingle($id){
			include "inc.php";
			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);
	
			$query ="SELECT * FROM canidate WHERE canidateID=$id";
			$results = $conn->query($query);
			$return = $results->fetch_all(MYSQLI_ASSOC);
			$conn->close();
			return $return;
		}
		function castVote($id){
			include "inc.php";
			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);

			$query ="SELECT * FROM canidate WHERE canidateID=$id";
			$results = $conn->query($query);
			$canidates = $results->fetch_all(MYSQLI_ASSOC);
			foreach($canidates as $canidate){
				$vote = $canidate['canidateCount'];
			}
			$vote++;

			$stmt =$conn->prepare("UPDATE canidate SET canidateCount=? WHERE canidateID=$id");
			$stmt->bind_param("i", $newVote);
			$newVote = mysqli_real_escape_string($conn, $vote);
			$stmt->execute();
			$stmt->close();
			
			$conn->close();


		}
		function ballotCast($id){
			include "inc.php";
			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);

			$query="SELECT * FROM ballot WHERE ballotID=$id";
			$results = $conn->query($query);
			$bals = $results->fetch_all(MYSQLI_ASSOC);
			foreach($bals as $bal){
				$cast = $bal['ballotCast'];
			}
			$cast++;
			$stmt =$conn->prepare("UPDATE ballot SET ballotCast=? WHERE ballotID=$id");
			$stmt->bind_param("i", $newCast);
			$newCast = mysqli_real_escape_string($conn, $cast);
			$stmt->execute();
			$stmt->close();

		}
	} 


?>
