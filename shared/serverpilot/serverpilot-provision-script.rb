require 'ServerPilot'
require 'logger'
require 'colorize'
require 'open-uri'

# Create new Logger
log = Logger.new('/home/vagrant/log.out')
log.progname = 'ServerPilot'
log.level = Logger::DEBUG

# Format the log output:
log.formatter = proc do |severity, datetime, progname, msg|

    # severity = "[" + severity + "]"

    datetime = datetime.strftime("[%b.%d-%H:%M:%S]")

    # progname = " - " + progname + " ↴\n"
    progname = "[" + progname + "]"

    msg = msg.to_s.chomp.split("\n")

    if msg.size > 1
       msg = " ↴\n    - " + msg.join("\n    - ")
    else
        msg = ": " + msg[0]
    end
    
    case severity
        when "DEBUG"
            ("[#{severity}]" + " " + progname).bold + " " + datetime + msg + "\n"
        when "INFO"
            ("[#{severity}]".green + " " + progname).bold + " " + datetime + msg + "\n"
        when "WARN"
            ("[#{severity}]".yellow + " " + progname).bold + " " + datetime + msg + "\n"
        when "ERROR"
            (("[#{severity}]" + " " + progname).bold + " " + datetime + msg).red + "\n"
        when "FATAL"
            (("[#{severity}]" + " " + progname + " " + datetime).on_light_red + msg.red).bold + "\n"
        else
            ("[UNKNOWN]".blue + " " + progname).bold + " " + datetime + msg + "\n"
    end

end

# Logger Tet Messages
# log.debug "This is a test Debug Message\nIt is two lines long"
# log.info "This is a test Info Message\nIt is going to be\nThree lines long"
# log.warn "This is a test Warning Message"
# log.error "This is a test Error Message"
# log.fatal "This is a test Fatal Message"
# log.unknown "This is a test Unknown Message"

CLIENT_ID = 'cid_IIQ3qWQlBRAN3B3X'
API_KEY = '1ro7a9s1Tr0Yw6MM63Ys8G0iTTjuV2sHsMEun5UEaTM'
SHARE_PATH = '/home/vagrant/shared/serverpilot'

sp = ServerPilot::API.new(CLIENT_ID, API_KEY)
# sp.scheme = 'https'

# If you want to list all servers
# server_list = sp.get_servers

# server_list.to_h.each { |k,v|
#     if k == :body
#         log.info "Existing Servers:\n" + JSON.pretty_generate(v['data'])
#     end
# }



##############################################################################
# Use the resources here to implement action monitoring if possible:
# https://github.com/ServerPilot/API#actions
##############################################################################



##############################################################################
# MUST CREATE ERROR HANDLER FOR SERVERPILOT API ERRORS!!
# HTTP Status Code Summary
# 200 OK - Everything worked as expected.
# 400 Bad Request - We couldn't understand your request. Typically missing a parameter or header.
# 401 Unauthorized - Either no authentication credentials were provided or they are invalid.
# 402 Payment Required - Method is restricted to users on the Coach or Business plan.
# 403 Forbidden - Typically when trying to alter or delete protected resources.
# 404 Not Found - You requested a resource that does not exist.
# 409 Conflict - Typically when trying creating a resource that already exists.
# 500 Server Error - Something unexpected happened on ServerPilot's end.
# Errors
# When you a receive a response with a status code in the 4xx or 5xx range, you'll receive a JSON object in the body with details.
    # The object will have a error and message key, like so:
        # {
        #     "error": {
        #         "message": "Password must be at least 8 characters."
        #     }
        # }
# MUST CREATE ERROR HANDLER FOR SERVERPILOT API ERRORS!!
##############################################################################



# Step 1: Add the server
log.info "Beginning Server Connection Process..."

begin
    # Switch lines below to force an error for testing
    # action = sp.post_servers 'flo-dev'
    action = sp.post_servers({name: 'flo-dev'})
rescue Exception => e
    log.error e
    abort
else
    action = action.to_h[:body]['data']

    SRVR_ID = action['id'].to_s.chomp
    SRVR_KEY = action['apikey'].to_s.chomp
    
    log.info "Success! The server was added to ServerPilot:\n" + ("   server_id => " + SRVR_ID + "\n   server_api_key => " + SRVR_KEY).bold

end

# Step 2: Download the provisioner
log.info "Downloading the provisioner script..."

begin
    File.open("#{SHARE_PATH}/serverpilot-installer.py", "wb") do |saved_file|
        open("https://download.serverpilot.io/serverpilot-installer", "rb") do |read_file|
            saved_file.write(read_file.read)
        end
    end
rescue Exception => e
    log.error e
    abort
else
    log.info "Success! We got the file!\n   " + `ls -l #{SHARE_PATH} | grep py`
end

# Step 3: Execute the provisioner
log.info "Executing the provisioner script..."
begin
    action = `sudo python #{SHARE_PATH}/serverpilot-installer.py --server-id=#{SRVR_ID} --server-apikey=#{SRVR_KEY}`
rescue Exception => e
    log.error e
    abort
else
    log.info action
    log.info "Success! This server has been successfully provisioned with ServerPilot!"
end

exit

##########################################################################################
# THIS ISNT WORKING RIGHT NOW... MIGHT NEED TO UPGRADE MY SERVERPILOT ACCOUNT
##########################################################################################
# Step 4: Create a system user so that we can create an app
log.info "Creating a new System User..."
begin
    action = sp.post_sysusers({serverid: SRVR_ID, name: 'serverpilot'})
rescue Exception => e
    log.error e
    abort
else
    USR_ID = action.to_h[:body]['data']['id']
    log.info "Success! The serverpilot user has been created!\nid => " + USR_ID
end

# Step 5: Create an app so that we can install wordpress
log.info "Creating an APP Profile..."
begin
    # Need to make these variables in the future maybe?
    action = sp.post_apps({name: 'wordpress', sysuserid: USR_ID, runtime: 'php7.0', domains: ['flo.dev']})
rescue Exception => e
    log.error e
    abort
else
    log.info "Success! The APP has been created! We are ready for Wordpress!\n" + JSON.pretty_generate(action.to_h[:body]['data'])
end
