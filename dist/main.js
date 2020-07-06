

function obtenerget()
{
   var contagiados;
    axios.get('http://localhost/proyectos/proyectojuan/v1/contagiados', {
      headers: {
        'Authorization': 'e14c60816f8af99193f62a811e6afbbf'
      }
    }).then(function (response) {
      //console.log(response.data.conteo);
      //console.log(JSON.stringify(response.data));
      contagiados = response.data;
      
     })
     .catch(function (error) {
      console.log(error);
     })
     .then(function () {
     });

}

function obtenergett(){
  return "joa";
}

// var contagiados = {
//   "conteo": "Numero de Contagios: 2",
//   "features": [{
//     "type": "Contagiado",
//     "id": 200,
//     "geometry": {
//       "type": "Point",
//       "coordinates": [-77.075241, -11.951198]
//     }
//   }, {
//     "type": "Contagiado",
//     "id": 434,
//     "geometry": {
//       "type": "Point",
//       "coordinates": [-77.075241, -11.951198]
//     }
//   }]
// }