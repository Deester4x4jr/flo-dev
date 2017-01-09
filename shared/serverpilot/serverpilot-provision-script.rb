require 'ServerPilot'

client_id = cid_PPdOrmNPimLw7aFZ
api_key = yoG3S3I2gpR26BkfBtcvUq7vQu5pK8bw8RHy0q9Byo8

sp = ServerPilot::API.new(client_id, api_key)

puts sp.get_servers