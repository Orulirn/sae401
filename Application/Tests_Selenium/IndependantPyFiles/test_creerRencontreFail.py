# Generated by Selenium IDE
import pytest
import time
import json
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support import expected_conditions
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities

class TestCreerRencontreFail():
  def setup_method(self, method):
    self.driver = webdriver.Chrome()
    self.vars = {}
  
  def teardown_method(self, method):
    self.driver.quit()
  
  def test_creerRencontreFail(self):
    self.driver.get("http://localhost/Application/Controller/Accueil/HomePageController.php")
    self.driver.set_window_size(1532, 804)
    self.driver.find_element(By.ID, "navbarDropdownMenuLink").click()
    self.driver.find_element(By.ID, "navbarModifierRecontre").click()
    self.driver.find_element(By.ID, "equipe1").click()
    self.driver.find_element(By.ID, "equipe2").click()
    dropdown = self.driver.find_element(By.ID, "equipe2")
    dropdown.find_element(By.XPATH, "//option[. = 'DAHAK']").click()
    self.driver.find_element(By.ID, "parcours").click()
    dropdown = self.driver.find_element(By.ID, "parcours")
    dropdown.find_element(By.XPATH, "//option[. = 'NewParcours']").click()
    self.driver.find_element(By.CSS_SELECTOR, ".btn:nth-child(5)").click()
    assert self.driver.find_element(By.ID, "swal2-title").text == "Erreur!"
    self.driver.find_element(By.CSS_SELECTOR, ".swal2-confirm").click()
    self.driver.close()
  
