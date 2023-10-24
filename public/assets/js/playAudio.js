/*
		maksimal 30 nomor antrian dan 9 loket
	*/

	function playAudioAntrian(nomor_antrian, nomor_loket){
		let pathAudio = './public/assets/audio1/';

		if(nomor_antrian < 10){
			pathAudio += nomor_antrian +'.wav';
		}
		else if(nomor_antrian == 10){
			pathAudio += 'sepuluh.wav';
		}
		else if(nomor_antrian == 11){
			pathAudio += 'sebelas.wav';
		}
		else if(nomor_antrian < 20){
			// 12 - 19
			const split = nomor_antrian.toString().charAt(1);
			pathAudio += split +'.wav';
		}
		else if(nomor_antrian == 20){
			pathAudio += '2.wav';
		}
		else if(nomor_antrian < 30){
			const split = nomor_antrian.toString().charAt(0);
			pathAudio += split +'.wav';
		}


		const startBell = new Audio('./public/assets/audio1/in.wav');
		const endBell = new Audio('./public/assets/audio1/out.wav');
		const audioNomorUrut = new Audio('./public/assets/audio1/nomor-urut.wav');
		const audioLoket = new Audio('./public/assets/audio1/loket.wav');
		const audioBelas = new Audio('./public/assets/audio1/belas.wav');
		const audioPuluh = new Audio('./public/assets/audio1/puluh.wav');
		const number_antrian = new Audio(pathAudio);
		const number_loket = new Audio('./public/assets/audio1/'+ nomor_loket +'.wav');

		if(nomor_antrian <= 11){
			playAudio(startBell, function(){
				playAudio(audioNomorUrut, function(){
					playAudio(number_antrian, function(){
						playAudio(audioLoket, function(){
							playAudio(number_loket, function(){
								playAudio(endBell);
							});
						});
					})
				});
			});
		}
		else if(nomor_antrian < 20){
			playAudio(startBell, function(){
				playAudio(audioNomorUrut, function(){
					playAudio(number_antrian, function(){
						playAudio(audioBelas, function(){
							playAudio(audioLoket, function(){
								playAudio(number_loket, function(){
									playAudio(endBell);
								});
							});
						});
					})
				});
			});
		}
		else if(nomor_antrian < 30){
			playAudio(startBell, function(){
				playAudio(audioNomorUrut, function(){
					playAudio(number_antrian, function(){
						playAudio(audioPuluh, function(){

							if(nomor_antrian > 20){
								const split2 = nomor_antrian.toString().charAt(1);
								const audioNew = new Audio('./public/assets/audio1/'+ split2 +'.wav');

								playAudio(audioNew, function(){
									playAudio(audioLoket, function(){
										playAudio(number_loket, function(){
											playAudio(endBell);
										});
									});
								});
							}
							else {
								playAudio(audioLoket, function(){
									playAudio(number_loket, function(){
										playAudio(endBell);
									});
								});
							}
						});
					})
				});
			});
		}
		else if(nomor_antrian == 30){
			const audioNew = new Audio('./public/assets/audio1/3.wav');

			playAudio(startBell, function(){
				playAudio(audioNomorUrut, function(){
					playAudio(audioNew, function(){
						playAudio(audioPuluh, function(){
							playAudio(audioLoket, function(){
								playAudio(number_loket, function(){
									playAudio(endBell);
								});
							});
						});
					})
				});
			});
		}
	}

	function playAudio(objAudio, callback){
		objAudio.play();
		objAudio.addEventListener('ended', callback);
	}
