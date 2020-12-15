IMAGE_NAME=cswl/xampp
CONTAINER_NAME=xamppy-docker
PUBLIC_WWW_DIR='~/web_pages'


echo "Running container '$CONTAINER_NAME' from image '$IMAGE_NAME'..."

docker start $CONTAINER_NAME > /dev/null 2> /dev/null || {
	echo "Creating new container..."
	docker run \
	       --detach \
	       --tty \
	       -p 8086:80 \
	       -p 3386:3306 \
	       -p 3000:8000 \
	       --name $CONTAINER_NAME \
	       --mount "source=$CONTAINER_NAME-vol,destination=/opt/lampp/var/mysql/" \
	       -v /Users/idscomercial/Downloads/pos/pos:/opt/lampp/htdocs/pos/ \
			$IMAGE_NAME
}

if [ "$#" -eq  "0" ]; then
	echo "Bash in a container running..."
	docker exec --interactive --tty $CONTAINER_NAME bash
elif [ "$1" = "stop" ]; then
	echo "Stopping the container..."
	docker stop $CONTAINER_NAME
else
	echo "Run new container with params..."
	docker exec $CONTAINER_NAME $@
fi

