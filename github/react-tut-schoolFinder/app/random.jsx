var React = require("react");
var ReactDOM = require("react-dom");
var AppBar = require('material-ui/lib/app-bar');

var Card = require('material-ui/lib/card/card');
var CardActions = require('material-ui/lib/card/card-actions');
var CardHeader = require('material-ui/lib/card/card-header');
var CardMedia = require('material-ui/lib/card/card-media');
var CardTitle = require('material-ui/lib/card/card-title');
var FlatButton = require('material-ui/lib/flat-button');
var CardText = require('material-ui/lib/card/card-text');

ReactDOM.render(<div>
	<AppBar title="h!nge Dashboard" style={{ paddingLeft:'0',paddingRight:'0',position: 'absolute' }} />
	<Card>
		<CardHeader
		  title="URL Avatar"
		  subtitle="Subtitle"
		  avatar="http://lorempixel.com/100/100/nature/" />
		<CardMedia
		  overlay={<CardTitle title="Overlay title" subtitle="Overlay subtitle" />}
		>
			<img src="http://lorempixel.com/600/337/nature/" />
		</CardMedia>
		<CardTitle title="Card title" subtitle="Card subtitle" />
		<CardText>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit.
			Donec mattis pretium massa. Aliquam erat volutpat. Nulla facilisi.
			Donec vulputate interdum sollicitudin. Nunc lacinia auctor quam sed pellentesque.
			Aliquam dui mauris, mattis quis lacus id, pellentesque lobortis odio.
		</CardText>
		<CardActions>
			<FlatButton label="Action1" />
			<FlatButton label="Action2" />
		</CardActions>
	</Card></div>,
	document.getElementById("container"));