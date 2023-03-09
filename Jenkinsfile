pipeline {
  agent any
  triggers {
    GenericTrigger(
      genericVariables: [
        [key: 'project', value: '$.project.name'],
        [key: 'ref', value: '$.ref']
      ],
      causeString: 'Triggered on $ref',
      token: '',
      tokenCredentialId: 'gitlab-token',
      printContributedVariables: true,
      printPostContent: true,
      silentResponse: false,
      regexpFilterText: '$project_$ref_refs/heads/dev',
      regexpFilterExpression: 'cyberlink-backend_refs/heads/' + BRANCH_NAME + '_refs/heads/' + BRANCH_NAME
    )
  }
  environment {
    PROJECT_NAME = "cyberlink-backend"
    PACKAGE_NAME = "${PROJECT_NAME}-${BRANCH_NAME}-${BUILD_ID}.tar.gz"
  }
  stages {
    stage('Build') {
      steps {
        sh '''
        echo "---Build---"
        composer install --optimize-autoloader --no-dev --ignore-platform-reqs
        php /home/www/root/backend/artisan apollo:load ${PROJECT_NAME} ${BRANCH_NAME}
        '''
      }
    }
    stage('Package') {
      steps {
        sh '''
        echo "---Package---"
        tar -zcf ${CODE_PATH}/${PACKAGE_NAME} --exclude='.git' .
        echo ${BUILD_ID} > ${CODE_PATH}/${PROJECT_NAME}-${BRANCH_NAME}.version
        '''
      }
    }
    stage('Clean') {
      steps {
        sh '''
        echo "---Clean---"
        rm -rf `ls ${CODE_PATH}/${PROJECT_NAME}-${BRANCH_NAME}-* -t|tail -n +4`
        '''
      }
    }
    stage('Tag') {
      when {
        branch 'master'
      }
      steps {
        sh '''
        echo "---Tag---"
        tagname="release-"$(date "+%Y%m%d")"."${BUILD_ID}
        git tag -a ${tagname} -m "Jenkins automatic build tag"
        git push git@git.int.joyfun.pro:backend/cyberlink-backend.git ${tagname}
        git tag -d ${tagname}
        '''
      }
    }
  }
  post {
    always {
      script {
        def result = "0"
        if (currentBuild.currentResult == 'SUCCESS') {
          result = "1"
        }

        def content = getChangeString()

        sh "php /home/www/root/backend/artisan build:notify ${PROJECT_NAME} ${BRANCH_NAME} ${result} ${currentBuild.number} ${currentBuild.duration} ${BUILD_URL} '${content}'"
      }
    }
  }
}

@NonCPS
def getChangeString() {
  def content = ""
  def changeLogSets = currentBuild.changeSets
  for (int i = 0; i < changeLogSets.size(); i++) {
    def entries = changeLogSets[i].items
    for (int j = 0; j < entries.length; j++) {
      def entry = entries[j]
      content = content + "[${entry.author}] ${entry.msg}\n"
    }
  }
  return content
}
